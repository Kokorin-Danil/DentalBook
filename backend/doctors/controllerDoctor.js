import User from "../users/modelUser.js";
import Doctor from "./modelDoctor.js";
import { validationResult } from "express-validator";
import jwt from "jsonwebtoken";
import dayjs from "dayjs";
import { Op } from "sequelize";
import dbST from "../utils/database.js";
import { PatientCard, Visit } from "../patientCard/modelPatientCard.js";
import fs from "fs";
import { uploadAvatar } from "../utils/middleware.js";

const createDoctor = async (req, res) => {
  const transaction = await dbST.transaction(); // Создаем транзакцию

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
    const newUser = await User.create(
      {
        firstName,
        lastName,
        email,
        password, // Предполагается, что пароль уже захеширован в модели User
        gender,
        role: "doctor", // Устанавливаем роль как doctor
      },
      { transaction } // Передаем транзакцию
    );

    // Создание нового врача, связываем его с только что созданным пользователем
    const newDoctor = await Doctor.create(
      {
        firstName,
        lastName,
        patronymic,
        dateOfBirth,
        email,
        specialty,
        mobilePhone, // Добавляем мобильный телефон
        userId: newUser.id, // Связываем врача с пользователем через userId
      },
      { transaction } // Передаем транзакцию
    );

    // Подтверждаем транзакцию
    await transaction.commit();

    return res.status(201).json({
      message: "Доктор успешно создан",
      doctor: newDoctor,
      user: newUser,
    });
  } catch (error) {
    // Откат транзакции в случае ошибки
    await transaction.rollback();
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
          attributes: ["firstName", "lastName", "email", "avatar"], // Подгружаем аватар
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
      mobilePhone: doctor.mobilePhone,
      avatar: doctor.userAccount.avatar, // Добавляем аватарку
    };

    res.status(200).json(response);
  } catch (error) {
    console.error("Ошибка при получении информации о докторе:", error);
    res.status(500).json({ message: "Ошибка сервера", error: error.message });
  }
};

const getDoctorVisits = async (req, res) => {
  try {
    // Извлекаем токен из заголовков
    const token = req.headers.authorization?.split(" ")[1];
    if (!token) {
      return res.status(401).json({ message: "Токен отсутствует" });
    }

    // Проверяем токен и извлекаем userId
    const decoded = jwt.verify(token, process.env.JWT_SECRET);
    const { id: userId } = decoded;

    // Ищем врача по userId
    const doctor = await Doctor.findOne({ where: { userId } });
    if (!doctor) {
      return res.status(404).json({ message: "Врач не найден" });
    }

    // Текущая дата
    const today = dayjs().format("YYYY-MM-DD");

    // Находим визиты врача на текущую дату
    const visits = await Visit.findAll({
      where: {
        doctorId: doctor.id,
        visitDate: today,
      },
      include: [
        {
          model: PatientCard,
          as: "patientCard",
          attributes: ["id", "firstName", "lastName", "patronymic"],
        },
      ],
      order: [["visitTime", "ASC"]], // Сортируем по времени визита
    });

    // Формируем результат для ответа
    const result = visits.map((visit) => ({
      id: visit.id,
      patient: {
        id: visit.patientCard.id,
        fullName: `${visit.patientCard.lastName} ${
          visit.patientCard.firstName
        } ${visit.patientCard.patronymic || ""}`.trim(),
      },
      visitType: visit.visitType,
      visitTime: visit.visitTime,
      visitStatus: visit.visitStatus,
    }));

    res.status(200).json(result);
  } catch (error) {
    console.error("Ошибка при получении визитов врача:", error);
    res.status(500).json({ message: "Ошибка сервера", error: error.message });
  }
};

const getAllDoctors = async (req, res) => {
  try {
    // Получаем всех врачей, включая аватарку из User
    const doctors = await Doctor.findAll({
      attributes: [
        "id",
        "firstName",
        "lastName",
        "patronymic",
        "email",
        "mobilePhone",
        "specialty",
      ],
      where: { isDeleted: false },
      include: [
        {
          model: User,
          as: "userAccount",
          attributes: ["avatar"], // Берем только аватарку
        },
      ],
    });

    // Форматируем результат
    const result = doctors.map((doctor) => ({
      id: doctor.id,
      fullName: `${doctor.lastName} ${doctor.firstName} ${
        doctor.patronymic || ""
      }`.trim(),
      email: doctor.email,
      mobilePhone: doctor.mobilePhone,
      specialty: doctor.specialty,
      avatar:
        doctor.userAccount?.avatar ||
        "/backend/uploads/avatars/default_avatar.png",
    }));

    res.status(200).json(result);
  } catch (error) {
    console.error("Ошибка при получении списка врачей:", error);
    res.status(500).json({ message: "Ошибка сервера", error: error.message });
  }
};

const getDoctorInfoById = async (req, res) => {
  try {
    const { doctorId } = req.params;

    // Поиск доктора по doctorId
    const doctor = await Doctor.findOne({
      where: { id: doctorId },
      include: [
        {
          model: User,
          as: "userAccount",
          attributes: ["firstName", "lastName", "email", "avatar"], // Подгружаем аватар
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
      mobilePhone: doctor.mobilePhone,
      avatar: doctor.userAccount.avatar, // Добавляем аватарку
    };

    res.status(200).json(response);
  } catch (error) {
    console.error("Ошибка при получении информации о докторе по ID:", error);
    res.status(500).json({ message: "Ошибка сервера", error: error.message });
  }
};

const getDoctorVisitsById = async (req, res) => {
  try {
    const { doctorId } = req.params;

    // Проверяем, существует ли доктор с таким ID
    const doctor = await Doctor.findByPk(doctorId);
    if (!doctor) {
      return res.status(404).json({ message: "Врач не найден" });
    }

    // Текущая дата
    const today = dayjs().format("YYYY-MM-DD");

    // Находим визиты врача на текущую дату
    const visits = await Visit.findAll({
      where: {
        doctorId: doctorId,
        visitDate: today,
      },
      include: [
        {
          model: PatientCard,
          as: "patientCard",
          attributes: ["id", "firstName", "lastName", "patronymic"],
        },
      ],
      order: [["visitTime", "ASC"]], // Сортируем по времени визита
    });

    // Формируем результат для ответа
    const result = visits.map((visit) => ({
      id: visit.id,
      patient: {
        id: visit.patientCard.id,
        fullName: `${visit.patientCard.lastName} ${
          visit.patientCard.firstName
        } ${visit.patientCard.patronymic || ""}`.trim(),
      },
      visitType: visit.visitType,
      visitTime: visit.visitTime,
      visitStatus: visit.visitStatus,
    }));

    res.status(200).json(result);
  } catch (error) {
    console.error("Ошибка при получении визитов врача по ID:", error);
    res.status(500).json({ message: "Ошибка сервера", error: error.message });
  }
};

const uploadDoctorAvatar = async (req, res) => {
  try {
    // Получение токена из заголовка Authorization
    const token = req.headers.authorization?.split(" ")[1];
    if (!token) {
      return res.status(401).json({ message: "Токен не предоставлен" });
    }

    // Расшифровка токена
    let decoded;
    try {
      decoded = jwt.verify(token, process.env.JWT_SECRET);
    } catch (err) {
      return res.status(401).json({ message: "Неверный или истёкший токен" });
    }

    // Извлекаем ID пользователя из токена
    const userId = decoded.id;

    // Ищем пользователя с ролью врача
    const user = await User.findOne({
      where: { id: userId, role: "doctor" },
      include: [
        {
          model: Doctor,
          as: "doctorProfile", // Убедитесь, что связь настроена корректно
        },
      ],
    });

    if (!user) {
      return res.status(404).json({ message: "Врач не найден" });
    }

    // Загрузка файла
    uploadAvatar.single("avatar")(req, res, async (err) => {
      if (err) {
        console.error("Ошибка multer:", err.message);
        return res.status(400).json({ message: err.message });
      }

      if (!req.file) {
        return res.status(400).json({ message: "Файл не был загружен" });
      }

      // Новый путь для аватарки
      const newAvatarPath = `/backend/uploads/avatars/${req.file.filename}`;

      // Удаление старой аватарки, если она не является стандартной
      if (
        user.avatar &&
        user.avatar !== "/backend/uploads/avatars/default_avatar.png"
      ) {
        fs.unlink(user.avatar, (err) => {
          if (err)
            console.error("Ошибка удаления старой аватарки:", err.message);
        });
      }

      // Обновление аватарки
      user.avatar = newAvatarPath;
      await user.save();

      return res.status(200).json({
        message: "Аватарка успешно обновлена",
        user: {
          id: user.id,
          firstName: user.firstName,
          lastName: user.lastName,
          avatar: user.avatar,
        },
      });
    });
  } catch (error) {
    console.error("Ошибка загрузки аватарки врача:", error);
    return res.status(500).json({ message: "Ошибка сервера" });
  }
};

export default {
  createDoctor,
  getDoctorInfo,
  getDoctorVisits,
  getAllDoctors,
  getDoctorInfoById,
  getDoctorVisitsById,
  uploadDoctorAvatar,
};
