import jwt from "jsonwebtoken";
import User from "./modelUser.js";
import { PatientCard } from "../patientCard/modelPatientCard.js";
import bcrypt from "bcrypt";
import dotenv from "dotenv";
import { format } from "date-fns";
import { ru } from "date-fns/locale";
import fs from "fs";
import path from "path";
import { uploadAvatar } from "../utils/middleware.js";

dotenv.config();

const JWT_SECRET = process.env.JWT_SECRET; // Секретный ключ для JWT

// Авторизация пользователя
export const login = async (req, res) => {
  try {
    const { email, password } = req.body;

    // Находим пользователя по email
    const user = await User.findOne({ where: { email } });
    if (!user) {
      return res.status(400).json({ message: "Пользователь не найден" });
    }

    // Сравниваем пароли
    const isPasswordValid = await user.comparePassword(password);
    if (!isPasswordValid) {
      return res.status(400).json({ message: "Неверный пароль" });
    }

    // Обновляем поле lastLogin
    user.lastLogin = new Date();
    await user.save();

    // Создание JWT токена
    const token = jwt.sign(
      { id: user.id, email: user.email, role: user.role },
      JWT_SECRET,
      { expiresIn: "10h" } // Токен будет действовать 5 часов
    );

    // Отправка токена клиенту
    return res.status(200).json({ token });
  } catch (error) {
    console.error("Ошибка при авторизации:", error);
    res.status(500).json({ message: "Ошибка сервера" });
  }
};

export const getClientProfile = async (req, res) => {
  try {
    // Получение токена из заголовка Authorization
    const token = req.headers.authorization?.split(" ")[1];
    if (!token) {
      return res.status(401).json({ message: "Токен не предоставлен" });
    }

    // Расшифровываем токен
    let decoded;
    try {
      decoded = jwt.verify(token, process.env.JWT_SECRET);
    } catch (err) {
      return res.status(401).json({ message: "Неверный или истёкший токен" });
    }

    // Извлекаем ID пользователя из токена
    const userId = decoded.id;

    // Получаем данные пользователя с привязкой к карте пациента
    const user = await User.findOne({
      where: { id: userId, role: "client" },
      include: [
        {
          model: PatientCard,
          as: "patientCard", // Убедитесь, что связь между User и PatientCard настроена
        },
      ],
    });

    if (!user) {
      return res.status(404).json({ message: "Клиент не найден" });
    }

    const patientCard = user.patientCard;

    // Форматируем дату рождения и дату последнего входа
    const dateOfBirthFormatted = patientCard
      ? format(new Date(patientCard.dateOfBirth), "dd.MM.yyyy", { locale: ru })
      : "Не указана";

    const lastLoginFormatted = user.lastLogin
      ? format(new Date(user.lastLogin), "dd MMMM yyyy, HH:mm", { locale: ru })
      : "Неизвестно";

    // Формируем данные профиля
    const profile = {
      fullName: `${user.firstName} ${user.lastName} ${
        patientCard?.patronymic || ""
      }`.trim(),
      dateOfBirth: dateOfBirthFormatted,
      phoneNumber: patientCard?.phoneNumber || "Не указан",
      email: user.email,
      address: patientCard?.address || "Не указан",
      lastLogin: lastLoginFormatted,
      avatar: user.avatar, // Добавляем путь к аватарке
    };

    return res.status(200).json({ profile });
  } catch (error) {
    console.error("Ошибка при получении профиля клиента:", error);
    return res.status(500).json({ message: "Ошибка сервера" });
  }
};

export const getPatientCardIdByFullName = async (req, res) => {
  try {
    // Получение токена из заголовка Authorization
    const token = req.headers.authorization?.split(" ")[1];
    if (!token) {
      return res.status(401).json({ message: "Токен не предоставлен" });
    }

    // Расшифровываем токен
    let decoded;
    try {
      decoded = jwt.verify(token, JWT_SECRET);
    } catch (err) {
      return res.status(401).json({ message: "Неверный или истёкший токен" });
    }

    // Проверяем роль пользователя
    if (decoded.role !== "doctor" && decoded.role !== "admin") {
      return res.status(403).json({ message: "Доступ запрещён" });
    }

    // Извлечение ФИО из тела запроса
    const { fullName } = req.body;
    if (!fullName) {
      return res
        .status(400)
        .json({ message: "Полное имя пациента обязательно" });
    }

    // Разделение ФИО на составляющие
    const parts = fullName.trim().split(/\s+/);
    if (parts.length < 2) {
      return res
        .status(400)
        .json({ message: "ФИО должно содержать минимум имя и фамилию" });
    }

    const [lastName, firstName, patronymic] = parts;

    // Поиск карты пациента
    const patientCard = await PatientCard.findOne({
      where: {
        firstName,
        lastName,
        ...(patronymic && { patronymic }), // Условие по отчеству, если оно передано
      },
    });

    if (!patientCard) {
      return res.status(404).json({ message: "Карта пациента не найдена" });
    }

    return res.status(200).json({ patientCardId: patientCard.id });
  } catch (error) {
    console.error("Ошибка при поиске карты пациента по ФИО:", error);
    return res.status(500).json({ message: "Ошибка сервера" });
  }
};

export const updateUser = async (req, res) => {
  try {
    const userId = req.user.id; // ID пользователя из токена
    const { firstName, lastName, email, gender } = req.body;

    const user = await User.findByPk(userId);

    if (!user) {
      return res.status(404).json({ message: "Пользователь не найден" });
    }

    // Обновление данных пользователя
    if (firstName) user.firstName = firstName;
    if (lastName) user.lastName = lastName;
    if (email) user.email = email;
    if (gender) user.gender = gender;

    // Если есть файл, обновляем аватарку
    if (req.file) {
      const avatar = `/backend/uploads/avatars/${req.file.filename}`;

      // Удаляем предыдущий файл аватарки
      if (user.avatar) {
        const oldAvatarPath = path.join(
          "/backend/uploads/avatars/",
          user.avatar
        );
        try {
          if (fs.existsSync(oldAvatarPath)) {
            fs.unlinkSync(oldAvatarPath);
          }
        } catch (unlinkError) {
          console.error("Ошибка при удалении старой аватарки:", unlinkError);
        }
      }

      user.avatar = avatar;
    }

    // Сохраняем все изменения за один раз
    await user.save();

    return res.status(200).json({
      message: "Данные пользователя успешно обновлены",
      user,
    });
  } catch (error) {
    console.error("Ошибка при обновлении данных пользователя:", error);

    // Удаляем загруженный файл, если произошла ошибка
    if (req.file) {
      const newAvatarPath = path.join("uploads/avatars", req.file.filename);
      try {
        if (fs.existsSync(newAvatarPath)) {
          fs.unlinkSync(newAvatarPath);
        }
      } catch (err) {
        console.error("Ошибка при удалении файла:", err);
      }
    }

    return res.status(500).json({ message: "Ошибка сервера" });
  }
};

export const uploadUserAvatar = async (req, res) => {
  try {
    const userId = req.user.id;

    uploadAvatar.single("avatar")(req, res, async (err) => {
      if (err) {
        console.error("Ошибка multer:", err.message);
        return res.status(400).json({ message: err.message });
      }

      if (!req.file) {
        return res.status(400).json({ message: "Файл не был загружен" });
      }

      const newAvatarPath = `/backend/uploads/avatars/${req.file.filename}`;

      const user = await User.findByPk(userId);
      if (!user) {
        fs.unlinkSync(req.file.path);
        return res.status(404).json({ message: "Пользователь не найден" });
      }

      user.avatar = newAvatarPath;
      await user.save();

      return res.status(200).json({
        message: "Аватарка успешно обновлена",
        user: user,
      });
    });
  } catch (error) {
    console.error("Ошибка загрузки аватарки:", error);
    return res.status(500).json({ message: "Ошибка сервера" });
  }
};

export const getPatientCardNumber = async (req, res) => {
  try {
    const { id } = req.user;
    console.log(id);

    // Проверяем, существует ли пользователь
    const user = await User.findByPk(id, {
      include: [
        {
          model: PatientCard,
          as: "patientCard",
          attributes: ["id"], // Получаем только номер карты (id)
        },
      ],
    });

    if (!user) {
      return res.status(404).json({ message: "Пользователь не найден" });
    }

    // Проверяем, есть ли у пользователя карта пациента
    if (!user.patientCard) {
      return res.status(404).json({
        message: "Карта пациента для данного пользователя не найдена",
      });
    }

    return res.status(200).json({
      message: "Номер карты пациента получен",
      patientCardId: user.patientCard.id,
    });
  } catch (error) {
    console.error("Ошибка при получении номера карты пациента:", error);
    return res
      .status(500)
      .json({ message: "Ошибка сервера при получении карты пациента" });
  }
};

export const checkPatientCard = async (req, res) => {
  try {
    const { patientCardId } = req.params;
    const { id: userId, role } = req.user; // Данные пользователя из authenticateToken

    if (role === "client") {
      const patientCard = await PatientCard.findOne({
        where: { id: patientCardId, clientId: userId },
      });

      if (!patientCard) {
        return res.status(403).json({ message: "Доступ запрещен" });
      }

      return res.status(200).json(patientCard);
    }

    // Если пользователь не клиент, просто получаем карту пациента
    const patientCard = await PatientCard.findByPk(patientCardId);

    if (!patientCard) {
      return res.status(404).json({ message: "Карта пациента не найдена" });
    }

    return res.status(200).json(patientCard);
  } catch (error) {
    console.error("Ошибка получения карты пациента:", error);
    return res.status(500).json({ message: "Ошибка сервера" });
  }
};
