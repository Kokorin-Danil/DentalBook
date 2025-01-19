import User from "../users/modelUser.js";
import Doctor from "../doctors/modelDoctor.js";
import { PatientCard } from "../patientCard/modelPatientCard.js";
import fs from "fs";
import path from "path";
import { validationResult } from "express-validator";
import { uploadAvatar } from "../utils/middleware.js";

export const createAdminUser = async (req, res) => {
  try {
    const { firstName, lastName, email, password, gender } = req.body;

    // Валидация данных
    if (!firstName || !lastName || !email || !password || !gender) {
      return res
        .status(400)
        .json({ message: "Все поля обязательны для заполнения" });
    }

    // Проверка существования пользователя с таким email
    const existingUser = await User.findOne({ where: { email } });
    if (existingUser) {
      return res
        .status(400)
        .json({ message: "Пользователь с таким email уже существует" });
    }

    // Создание нового пользователя с ролью "admin"
    const newUser = await User.create({
      firstName,
      lastName,
      email,
      password: password,
      gender,
      role: "admin", // Устанавливаем роль "admin"
    });

    return res.status(201).json({
      message: "Пользователь с ролью admin успешно создан",
      user: {
        id: newUser.id,
        firstName: newUser.firstName,
        lastName: newUser.lastName,
        email: newUser.email,
        avatar: newUser.avatar, // Возвращаем аватар по умолчанию
      },
    });
  } catch (error) {
    console.error("Ошибка при создании пользователя:", error);
    return res.status(500).json({ message: "Ошибка сервера" });
  }
};

export const getAllDoctors = async (req, res) => {
  try {
    // Проверяем роль пользователя из токена
    const { role } = req.user;
    if (role !== "admin") {
      return res
        .status(403)
        .json({ message: "Доступ запрещен. Необходима роль admin" });
    }

    // Получаем список всех врачей с подробной информацией
    const doctors = await Doctor.findAll({
      include: [
        {
          model: User,
          as: "userAccount",
          attributes: ["firstName", "lastName", "email", "avatar"],
        },
      ],
    });

    if (doctors.length === 0) {
      return res.status(404).json({ message: "Врачи не найдены" });
    }

    // Формируем список врачей с нужными данными
    const doctorProfiles = doctors.map((doctor) => {
      return {
        doctorId: doctor.id,
        firstName: doctor.firstName,
        lastName: doctor.lastName,
        patronymic: doctor.patronymic,
        dateOfBirth: doctor.dateOfBirth,
        email: doctor.email,
        mobilePhone: doctor.mobilePhone,
        specialty: doctor.specialty,
        avatar: doctor.userAccount.avatar, // Аватар из модели User
      };
    });

    return res.status(200).json({ doctors: doctorProfiles });
  } catch (error) {
    console.error("Ошибка при получении списка врачей:", error);
    return res.status(500).json({ message: "Ошибка сервера" });
  }
};

export const getAllPatients = async (req, res) => {
  try {
    // Проверяем роль пользователя из токена
    const { role } = req.user;
    if (role !== "admin") {
      return res
        .status(403)
        .json({ message: "Доступ запрещен. Необходима роль admin" });
    }

    // Получаем список всех пациентов с подробной информацией
    const patients = await PatientCard.findAll({
      include: [
        {
          model: User,
          as: "user", // Используем алиас, определенный в ассоциации
          attributes: ["firstName", "lastName", "email", "avatar"], // Подгружаем информацию из модели User
        },
      ],
    });

    if (patients.length === 0) {
      return res.status(404).json({ message: "Пациенты не найдены" });
    }

    // Формируем список пациентов с нужными данными
    const patientProfiles = patients.map((patient) => {
      return {
        patientId: patient.id,
        firstName: patient.firstName,
        lastName: patient.lastName,
        patronymic: patient.patronymic,
        dateOfBirth: patient.dateOfBirth,
        address: patient.address,
        phoneNumber: patient.phoneNumber,
        email: patient.email,
        gender: patient.gender,
        policyNumber: patient.policyNumber,
        snils: patient.snils,
        passport: patient.passport,
        avatar: patient.user.avatar, // Аватар из модели User
      };
    });

    return res.status(200).json({ patients: patientProfiles });
  } catch (error) {
    console.error("Ошибка при получении списка пациентов:", error);
    return res.status(500).json({ message: "Ошибка сервера" });
  }
};

const deleteFileIfExists = (relativeFilePath) => {
  const filePath = relativeFilePath.startsWith("/backend")
    ? path.join(process.cwd(), relativeFilePath.slice(8)) // Убираем "/backend"
    : path.join(process.cwd(), relativeFilePath);

  fs.access(filePath, fs.constants.F_OK, (err) => {
    if (err) {
      console.log(`Файл не найден: ${filePath}`);
    } else {
      fs.unlink(filePath, (unlinkErr) => {
        if (unlinkErr) {
          console.error(
            `Ошибка удаления файла ${filePath}:`,
            unlinkErr.message
          );
        } else {
          console.log(`Файл ${filePath} успешно удалён`);
        }
      });
    }
  });
};

export const updatePatientAvatar = async (req, res) => {
  try {
    const { patientCardId } = req.params;

    // Проверяем наличие файла
    if (!req.file) {
      return res.status(400).json({ message: "Файл аватарки не передан" });
    }

    const patient = await PatientCard.findByPk(patientCardId, {
      include: [{ model: User, as: "user" }],
    });

    if (!patient) {
      return res.status(404).json({ message: "Пациент не найден" });
    }

    const user = patient.user;

    // Удаляем старую аватарку, если она есть
    if (
      user.avatar &&
      user.avatar !== "/backend/uploads/avatars/default_avatar.png"
    ) {
      deleteFileIfExists(user.avatar);
    }

    // Обновляем путь к новой аватарке
    const avatarPath = `/backend/uploads/avatars/${req.file.filename}`;
    user.avatar = avatarPath;

    await user.save();

    return res.status(200).json({
      message: "Аватарка обновлена",
      avatar: user.avatar,
    });
  } catch (error) {
    console.error("Ошибка при обновлении аватарки:", error);
    return res
      .status(500)
      .json({ message: "Ошибка сервера при обновлении аватарки" });
  }
};

export const updatePatientData = async (req, res) => {
  try {
    const { patientCardId } = req.params;

    // Находим пациента по id
    const patient = await PatientCard.findByPk(patientCardId, {
      include: [{ model: User, as: "user" }],
    });

    if (!patient) {
      return res.status(404).json({ message: "Пациент не найден" });
    }

    // Получаем данные из body
    const {
      firstName,
      lastName,
      patronymic,
      dateOfBirth,
      address,
      phoneNumber,
      email,
      gender,
      policyNumber,
      snils,
      passport,
    } = req.body;

    // Обновляем данные пациента
    const updatedPatientData = {
      firstName,
      lastName,
      patronymic,
      dateOfBirth,
      address,
      phoneNumber,
      email,
      gender,
      policyNumber,
      snils,
      passport,
    };

    await patient.update(updatedPatientData);

    // Обновляем данные пользователя
    const user = patient.user;
    const updatedUserData = {
      email,
      firstName,
      lastName,
      patronymic,
      phoneNumber,
    };

    await user.update(updatedUserData);

    return res.status(200).json({
      message: "Информация о пациенте успешно обновлена",
      patient: {
        patientId: patient.id,
        firstName: patient.firstName,
        lastName: patient.lastName,
        patronymic: patient.patronymic,
        dateOfBirth: patient.dateOfBirth,
        address: patient.address,
        phoneNumber: patient.phoneNumber,
        email: patient.email,
        gender: patient.gender,
        policyNumber: patient.policyNumber,
        snils: patient.snils,
        passport: patient.passport,
      },
    });
  } catch (error) {
    console.error("Ошибка при обновлении данных пациента:", error);
    return res
      .status(500)
      .json({ message: "Ошибка сервера при обновлении данных пациента" });
  }
};
