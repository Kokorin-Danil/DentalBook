import User from "../users/modelUser.js";
import Doctor from "./modelDoctor.js";
import { validationResult } from "express-validator";
import jwt from "jsonwebtoken";

const createDoctor = async (req, res) => {
  try {
    // Валидация данных
    const errors = validationResult(req);
    if (!errors.isEmpty()) {
      return res.status(400).json({ errors: errors.array() });
    }

    const {
      firstName,
      lastName,
      patronymic,
      dateOfBirth,
      email,
      specialty,
      password,
      gender,
      mobilePhone,
    } = req.body;

    // Проверка на существование пользователя с таким email
    const existingUser = await User.findOne({ where: { email } });
    if (existingUser) {
      return res
        .status(400)
        .json({ message: "User with this email already exists" });
    }

    // Создание нового пользователя с ролью doctor
    const newUser = await User.create({
      firstName,
      lastName,
      email,
      password, // Предполагается, что пароль уже захеширован в модели User
      gender,
      role: "doctor", // Устанавливаем роль как doctor
    });

    // Создание нового врача, связываем его с только что созданным пользователем
    const newDoctor = await Doctor.create({
      firstName,
      lastName,
      patronymic,
      dateOfBirth,
      email,
      specialty,
      mobilePhone, // Добавляем мобильный телефон
      userId: newUser.id, // Связываем врача с пользователем через userId
    });

    return res.status(201).json({
      message: "Доктор успешно создан",
      doctor: newDoctor,
      user: newUser,
    });
  } catch (error) {
    console.error(error);
    return res.status(500).json({ message: "Server error" });
  }
};

const getDoctorInfo = async (req, res) => {
  try {
    const token = req.headers.authorization?.split(" ")[1];
    if (!token) {
      return res.status(401).json({ message: "Токен не предоставлен" });
    }

    // Расшифровываем токен
    let decodedToken;
    try {
      decodedToken = jwt.verify(token, process.env.JWT_SECRET);
    } catch (error) {
      return res.status(401).json({ message: "Неверный токен" });
    }

    const { id: userId, role } = decodedToken;

    // Проверка роли
    if (role !== "doctor") {
      return res
        .status(403)
        .json({ message: "Доступ запрещён. Роль не doctor" });
    }

    // Поиск доктора по userId
    const doctor = await Doctor.findOne({
      where: { userId },
      include: [
        {
          model: User,
          as: "userAccount",
          attributes: ["firstName", "lastName", "email"],
        },
      ],
    });

    if (!doctor) {
      return res.status(404).json({ message: "Доктор не найден" });
    }

    // Формируем ответ
    const response = {
      fullName: `${doctor.lastName} ${doctor.firstName} ${
        doctor.patronymic || ""
      }`.trim(),
      dateOfBirth: doctor.dateOfBirth,
      specialty: doctor.specialty,
      email: doctor.email,
      mobilePhone: doctor.mobilePhone, // Добавляем мобильный телефон
    };

    res.status(200).json(response);
  } catch (error) {
    console.error("Ошибка при получении информации о докторе:", error);
    res.status(500).json({ message: "Ошибка сервера", error: error.message });
  }
};

export default {
  createDoctor,
  getDoctorInfo,
};
