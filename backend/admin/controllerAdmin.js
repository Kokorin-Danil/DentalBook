import User from "../users/modelUser.js";
import Doctor from "../doctors/modelDoctor.js";
import {
  PatientCard,
  Visit,
  PatientNote,
  Snapshot,
  ExaminationSheet,
} from "../patientCard/modelPatientCard.js";
import fs from "fs/promises";
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

const deleteFileIfExists = async (filePath) => {
  try {
    const normalizedPath = filePath.startsWith("/backend/")
      ? filePath.replace("/backend/", "")
      : filePath; // Убираем `/backend/` из пути

    // Проверяем существование файла
    await fs.access(normalizedPath);
    // Удаляем файл
    await fs.unlink(normalizedPath);
    console.log(`Файл успешно удалён: ${normalizedPath}`);
  } catch (error) {
    if (error.code !== "ENOENT") {
      console.error(`Ошибка при удалении файла: ${filePath}`, error);
    } else {
      console.warn(`Файл не существует: ${filePath}`);
    }
  }
};

export const updatePatientAvatar = async (req, res) => {
  let uploadedFilePath = null; // Для отслеживания созданного файла

  try {
    const { patientCardId } = req.params;
    const { role } = req.user;

    // Проверяем роль
    if (role !== "admin") {
      return res
        .status(403)
        .json({ message: "Доступ запрещен. Необходима роль admin" });
    }

    // Проверяем наличие файла
    if (!req.file) {
      return res.status(400).json({ message: "Файл аватарки не передан" });
    }

    // Сохраняем путь загруженного файла
    uploadedFilePath = `/backend/uploads/avatars/${req.file.filename}`;

    // Ищем пациента
    const patient = await PatientCard.findByPk(patientCardId, {
      include: [{ model: User, as: "user" }],
    });

    if (!patient) {
      throw new Error("Пациент не найден");
    }

    const user = patient.user;

    // Удаляем старую аватарку, если она не является аватаркой по умолчанию
    if (
      user.avatar &&
      user.avatar !== "/backend/uploads/avatars/default_avatar.png"
    ) {
      await deleteFileIfExists(user.avatar);
    }

    // Обновляем путь к новой аватарке
    user.avatar = uploadedFilePath;

    // Сохраняем изменения
    await user.save();

    return res.status(200).json({
      message: "Аватарка обновлена",
      avatar: user.avatar,
    });
  } catch (error) {
    console.error("Ошибка при обновлении аватарки:", error);

    // Удаляем загруженный файл при ошибке
    if (uploadedFilePath) {
      await deleteFileIfExists(uploadedFilePath);
    }

    return res
      .status(500)
      .json({ message: "Ошибка сервера при обновлении аватарки" });
  }
};

export const updatePatientData = async (req, res) => {
  try {
    const { patientCardId } = req.params;

    const { role } = req.user;
    if (role !== "admin") {
      return res
        .status(403)
        .json({ message: "Доступ запрещен. Необходима роль admin" });
    }

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

export const updateDoctorAvatar = async (req, res) => {
  try {
    const { doctorId } = req.params;
    const { role } = req.user;

    // Проверка роли пользователя
    if (role !== "admin") {
      if (req.file) {
        // Удаляем загруженный файл, если произошла ошибка авторизации
        deleteFileIfExists(`/backend/uploads/avatars/${req.file.filename}`);
      }
      return res
        .status(403)
        .json({ message: "Доступ запрещен. Необходима роль admin" });
    }

    // Проверяем наличие файла
    if (!req.file) {
      return res.status(400).json({ message: "Файл аватарки не передан" });
    }

    // Находим врача по его ID с привязкой к пользователю
    const doctor = await Doctor.findByPk(doctorId, {
      include: [{ model: User, as: "userAccount" }], // Используем правильный alias
    });

    if (!doctor) {
      // Удаляем загруженный файл, если врач не найден
      deleteFileIfExists(`/backend/uploads/avatars/${req.file.filename}`);
      return res.status(404).json({ message: "Врач не найден" });
    }

    const user = doctor.userAccount;

    // Удаляем старую аватарку, если она не дефолтная
    if (
      user.avatar &&
      user.avatar !== "/backend/uploads/avatars/default_avatar.png"
    ) {
      deleteFileIfExists(user.avatar);
    }

    // Сохраняем новую аватарку
    const avatarPath = `/backend/uploads/avatars/${req.file.filename}`;
    user.avatar = avatarPath;

    await user.save();

    return res.status(200).json({
      message: "Аватарка врача обновлена",
      avatar: user.avatar,
    });
  } catch (error) {
    console.error("Ошибка при обновлении аватарки врача:", error);

    // Удаляем файл, если произошла ошибка
    if (req.file) {
      deleteFileIfExists(`/backend/uploads/avatars/${req.file.filename}`);
    }

    return res
      .status(500)
      .json({ message: "Ошибка сервера при обновлении аватарки врача" });
  }
};

export const updateDoctorData = async (req, res) => {
  try {
    const { doctorId } = req.params;
    const { role } = req.user;

    // Проверка роли
    if (role !== "admin") {
      return res
        .status(403)
        .json({ message: "Доступ запрещен. Необходима роль admin" });
    }

    // Находим врача с корректным алиасом
    const doctor = await Doctor.findByPk(doctorId, {
      include: [{ model: User, as: "userAccount" }], // Исправлено на "userAccount"
    });

    if (!doctor) {
      return res.status(404).json({ message: "Врач не найден" });
    }

    const user = doctor.userAccount;

    // Получаем данные из тела запроса
    const {
      firstName,
      lastName,
      patronymic,
      dateOfBirth,
      email,
      mobilePhone,
      specialty,
    } = req.body;

    // Обновляем данные врача
    const updatedDoctorData = {
      firstName,
      lastName,
      patronymic,
      dateOfBirth,
      email,
      mobilePhone,
      specialty,
    };
    await doctor.update(updatedDoctorData);

    // Обновляем данные пользователя
    const updatedUserData = {
      firstName,
      lastName,
      patronymic,
      email,
    };
    await user.update(updatedUserData);

    return res.status(200).json({
      message: "Информация о враче успешно обновлена",
      doctor: {
        doctorId: doctor.id,
        firstName: doctor.firstName,
        lastName: doctor.lastName,
        patronymic: doctor.patronymic,
        dateOfBirth: doctor.dateOfBirth,
        email: doctor.email,
        mobilePhone: doctor.mobilePhone,
        specialty: doctor.specialty,
      },
    });
  } catch (error) {
    console.error("Ошибка при обновлении данных врача:", error);
    return res
      .status(500)
      .json({ message: "Ошибка сервера при обновлении данных врача" });
  }
};

export const deleteVisit = async (req, res) => {
  try {
    const { visitId } = req.params;
    const { role } = req.user;

    // Проверка роли
    if (role !== "admin") {
      return res
        .status(403)
        .json({ message: "Доступ запрещен. Необходима роль admin" });
    }

    // Находим визит по ID
    const visit = await Visit.findByPk(visitId);

    if (!visit) {
      return res.status(404).json({ message: "Визит не найден" });
    }

    // Удаляем визит
    await visit.destroy();

    return res.status(200).json({
      message: "Визит успешно удален",
    });
  } catch (error) {
    console.error("Ошибка при удалении визита:", error);
    return res
      .status(500)
      .json({ message: "Ошибка сервера при удалении визита" });
  }
};

export const deletePatientNote = async (req, res) => {
  try {
    const { patientNoteId } = req.params;
    const { role } = req.user;

    // Проверка роли
    if (role !== "admin") {
      return res
        .status(403)
        .json({ message: "Доступ запрещен. Необходима роль admin" });
    }

    // Поиск примечания по ID
    const note = await PatientNote.findByPk(patientNoteId);

    if (!note) {
      return res.status(404).json({ message: "Примечание не найдено" });
    }

    // Удаляем примечание
    await note.destroy();

    return res.status(200).json({
      message: "Примечание успешно удалено",
    });
  } catch (error) {
    console.error("Ошибка при удалении примечания:", error);
    return res
      .status(500)
      .json({ message: "Ошибка сервера при удалении примечания" });
  }
};

export const deleteSnapshot = async (req, res) => {
  try {
    const { snapshotId } = req.params;
    const { role } = req.user;

    // Проверка роли пользователя
    if (role !== "admin") {
      return res
        .status(403)
        .json({ message: "Доступ запрещен. Необходима роль admin" });
    }

    // Поиск снимка в базе данных
    const snapshot = await Snapshot.findByPk(snapshotId);
    if (!snapshot) {
      return res.status(404).json({ message: "Снимок не найден" });
    }

    // Удаление файла снимка с сервера
    try {
      await fs.unlink(snapshot.snapshotFile.replace("/backend/", ""));
    } catch (fileError) {
      console.error("Ошибка при удалении файла снимка:", fileError);
      return res
        .status(500)
        .json({ message: "Ошибка при удалении файла снимка" });
    }

    // Удаление записи снимка из базы данных
    await snapshot.destroy();

    return res
      .status(200)
      .json({ message: "Снимок успешно удален", snapshotId: snapshotId });
  } catch (error) {
    console.error("Ошибка при удалении снимка:", error);
    return res.status(500).json({
      message: "Ошибка сервера при удалении снимка",
      error: error.message,
    });
  }
};

export const createManager = async (req, res) => {
  try {
    // Получаем данные из тела запроса
    const { firstName, lastName, email, password, gender } = req.body;

    // Проверяем, что токен отправлен и валиден
    const { user } = req;
    if (!user || user.role !== "admin") {
      return res.status(403).json({
        message:
          "Доступ запрещен. Только администратор может создавать менеджеров.",
      });
    }

    // Проверяем обязательные поля
    if (!firstName || !lastName || !email || !password || !gender) {
      return res
        .status(400)
        .json({ message: "Все поля обязательны для заполнения." });
    }

    // Проверяем, существует ли пользователь с таким email
    const existingUser = await User.findOne({ where: { email } });
    if (existingUser) {
      return res
        .status(409)
        .json({ message: "Пользователь с таким email уже существует." });
    }

    // Создаем нового пользователя
    const newManager = await User.create({
      firstName,
      lastName,
      email,
      password: password,
      gender,
      role: "manager", // Назначаем роль менеджера
    });

    res.status(201).json({
      message: "Менеджер успешно создан.",
      user: {
        id: newManager.id,
        firstName: newManager.firstName,
        lastName: newManager.lastName,
        email: newManager.email,
        gender: newManager.gender,
        role: newManager.role,
      },
    });
  } catch (error) {
    console.error("Ошибка при создании менеджера:", error);
    res.status(500).json({ message: "Ошибка сервера." });
  }
};

export const deleteExaminationSheet = async (req, res) => {
  try {
    // Извлекаем ID записи из параметров запроса
    const { id } = req.params;

    // Проверяем, что пользователь аутентифицирован и является администратором
    const { user } = req;
    if (!user || user.role !== "admin") {
      return res.status(403).json({
        message: "Доступ запрещен. Только администратор может удалять записи.",
      });
    }

    // Проверяем, существует ли запись с указанным ID
    const examinationSheet = await ExaminationSheet.findByPk(id);
    if (!examinationSheet) {
      return res
        .status(404)
        .json({ message: "Запись не найдена. Проверьте корректность ID." });
    }

    // Удаляем запись
    await examinationSheet.destroy();

    res.status(200).json({ message: "Запись успешно удалена." });
  } catch (error) {
    console.error("Ошибка при удалении записи:", error);
    res.status(500).json({ message: "Ошибка сервера." });
  }
};
