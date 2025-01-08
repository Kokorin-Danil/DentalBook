import User from "../users/modelUser.js";
import Doctor from "./modelDoctor.js";
import { validationResult } from "express-validator";

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
      email,
      specialty,
      password,
      gender,
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
      patronymic, // Добавляем отчество
      email,
      specialty,
      userId: newUser.id, // Связываем врача с пользователем через userId
    });

    return res.status(201).json({ doctor: newDoctor, user: newUser });
  } catch (error) {
    console.error(error);
    return res.status(500).json({ message: "Server error" });
  }
};

export default {
  createDoctor,
};
