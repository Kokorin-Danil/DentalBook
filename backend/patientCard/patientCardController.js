import {
  PatientCard,
  Visit,
  PatientNote,
  Snapshot,
  Tooth,
  ToothStatus,
  ExaminationSheet,
} from "./modelPatientCard.js";
import User from "../users/modelUser.js";
import jwt from "jsonwebtoken";
import dotenv from "dotenv";
import crypto from "crypto";
import Doctor from "../doctors/modelDoctor.js";
import { Op, fn, col } from "sequelize";
import dayjs from "dayjs";
import path from "path";
import fs from "fs/promises";
import MedicalSurvey from "./MedicalSurveyModel.js";
dotenv.config();

const JWT_SECRET = process.env.JWT_SECRET;

const generateRandomPassword = () => {
  return crypto.randomBytes(8).toString("hex"); // Генерирует 16-символьный случайный пароль
};

export const createPatientCard = async (req, res) => {
  try {
    const token = req.headers.authorization?.split(" ")[1];
    if (!token) {
      return res.status(401).json({ message: "Токен не предоставлен" });
    }

    const decoded = jwt.verify(token, JWT_SECRET);

    if (!["doctor", "manager"].includes(decoded.role)) {
      return res.status(403).json({
        message:
          "Доступ запрещен. Только врачи или менеджеры могут создавать карты.",
      });
    }

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

    // Проверка на существование карты с таким номером полиса
    const existingPolicy = await PatientCard.findOne({
      where: { policyNumber },
    });
    if (existingPolicy) {
      return res.status(400).json({ message: "Полис уже зарегистрирован." });
    }

    const existingUser = await User.findOne({ where: { email } });
    if (existingUser) {
      return res
        .status(400)
        .json({ message: "Пользователь с таким email уже существует." });
    }

    const randomPassword = generateRandomPassword();

    const clientUser = await User.create({
      firstName,
      lastName,
      email,
      password: randomPassword,
      role: "client",
      gender,
    });

    const patientCard = await PatientCard.create({
      firstName,
      lastName,
      patronymic,
      dateOfBirth,
      address,
      phoneNumber,
      email,
      gender,
      clientId: clientUser.id,
      policyNumber,
      snils,
      passport,
    });

    return res.status(201).json({
      message: "Карта пациента успешно создана",
      patientCard,
      clientCredentials: {
        email,
        password: randomPassword,
      },
    });
  } catch (error) {
    console.error("Ошибка при создании карты пациента:", error);
    res.status(500).json({ message: "Ошибка сервера" });
  }
};

export const createVisit = async (req, res) => {
  const visitDate = req.body.visitDate.trim(); // 2024-12-28
  const visitTime = req.body.visitTime.trim(); // 16:00:00

  const visitDateTimeString = `${visitDate}T${visitTime}:00`; // Формируем строку даты и времени
  const visitStartTime = dayjs(visitDateTimeString);

  if (!visitStartTime.isValid()) {
    return res.status(400).json({ message: "Invalid visit time" });
  }

  try {
    // Проверка токена
    const token = req.headers.authorization?.split(" ")[1];
    if (!token) {
      return res
        .status(401)
        .json({ message: "Authorization token is missing" });
    }

    const decoded = jwt.verify(token, JWT_SECRET);
    if (!decoded) {
      return res.status(401).json({ message: "Invalid or expired token" });
    }

    const user = await User.findByPk(decoded.id);
    if (!user || !(user.role === "manager" || user.role === "doctor")) {
      return res.status(403).json({
        message: "Access denied, only admins or doctors can create visits",
      });
    }

    // Извлекаем данные из тела запроса
    const { doctorFullName, patientCardId, visitType } = req.body;

    // Поиск врача по полному ФИО
    const [doctorLastName, doctorFirstName, doctorPatronymic] =
      doctorFullName.split(" ");
    const doctor = await Doctor.findOne({
      where: {
        firstName: doctorFirstName,
        lastName: doctorLastName,
        patronymic: doctorPatronymic || null, // Если отчество указано
      },
    });
    if (!doctor) {
      return res.status(404).json({ message: "Doctor not found" });
    }

    // Поиск пациента по полному ФИО
    const patientCard = await PatientCard.findByPk(patientCardId);
    if (!patientCard) {
      return res.status(404).json({ message: "Patient card not found" });
    }

    // Определяем длительность визита
    let visitDuration;
    if (visitType === "лечение") {
      visitDuration = 60;
    } else if (["осмотр", "консультация"].includes(visitType)) {
      visitDuration = 30;
    } else {
      return res.status(400).json({ message: "Invalid visit type" });
    }

    const visitEndTime = visitStartTime.add(visitDuration, "minute");

    // Проверка пересечения времени визитов
    const existingVisit = await Visit.findOne({
      where: {
        doctorId: doctor.id,
        visitDate,
        [Op.and]: [
          { visitTime: { [Op.lt]: visitEndTime.format("HH:mm:ss") } },
          { visitTime: { [Op.gte]: visitStartTime.format("HH:mm:ss") } },
        ],
      },
    });

    if (existingVisit) {
      return res
        .status(400)
        .json({ message: "The doctor already has a visit at this time" });
    }

    // Проверка на пересечение с лечением
    if (visitType !== "лечение") {
      const existingTreatmentVisit = await Visit.findOne({
        where: {
          doctorId: doctor.id,
          visitDate,
          visitType: "лечение",
          [Op.or]: [
            { visitTime: { [Op.lte]: visitStartTime.format("HH:mm:ss") } },
            { visitTime: { [Op.gte]: visitEndTime.format("HH:mm:ss") } },
          ],
        },
      });

      if (existingTreatmentVisit) {
        const treatmentEndTime = dayjs(
          `${visitDate}T${existingTreatmentVisit.visitTime}`
        ).add(60, "minute");

        if (visitStartTime.isBefore(treatmentEndTime)) {
          return res.status(400).json({
            message: `The doctor already has a treatment visit that ends at ${treatmentEndTime.format(
              "HH:mm:ss"
            )}.`,
          });
        }
      }
    }

    // Создание визита
    const newVisit = await Visit.create({
      patientCardId: patientCard.id,
      doctorId: doctor.id,
      visitType,
      visitDate,
      visitTime: visitStartTime.format("HH:mm:ss"),
    });

    return res.status(201).json({ visit: newVisit });
  } catch (error) {
    console.error(error);
    return res.status(500).json({ message: "Server error" });
  }
};

export const changeVisitStatus = async (req, res) => {
  try {
    // Проверка наличия токена в заголовке Authorization
    const token = req.headers.authorization?.split(" ")[1];
    if (!token) {
      return res
        .status(401)
        .json({ message: "Authorization token is missing" });
    }

    // Верификация JWT токена
    const decoded = jwt.verify(token, process.env.JWT_SECRET);
    if (!decoded) {
      return res.status(401).json({ message: "Invalid or expired token" });
    }

    // Проверяем роль пользователя (если требуется)
    const user = await User.findByPk(decoded.id);
    if (!user || !(user.role === "admin" || user.role === "doctor")) {
      return res.status(403).json({
        message:
          "Access denied, only admins or doctors can change visit status",
      });
    }

    // Извлекаем данные из тела запроса
    const { newStatus } = req.body;
    const visitId = req.params.visitId;

    // Проверяем, что статус визита является допустимым
    const validStatuses = ["Не подтвержден", "Подтвержден", "Отменен"];
    if (!validStatuses.includes(newStatus)) {
      return res.status(400).json({ message: "Invalid visit status" });
    }

    // Поиск визита по ID
    const visit = await Visit.findByPk(visitId);
    if (!visit) {
      return res.status(404).json({ message: "Visit not found" });
    }

    // Обновление статуса визита
    visit.visitStatus = newStatus;
    await visit.save();

    // Возвращаем успешный ответ
    return res.status(200).json({ visit: visit });
  } catch (error) {
    console.error(error);
    return res.status(500).json({ message: "Server error" });
  }
};

export const getClientVisits = async (req, res) => {
  try {
    // Получаем ID клиента из параметров маршрута
    const cardId = req.params.PatientCardId;

    // Проверка наличия токена в заголовке Authorization
    const token = req.headers.authorization?.split(" ")[1];
    if (!token) {
      return res
        .status(401)
        .json({ message: "Authorization token is missing" });
    }

    // Верификация JWT токена
    const decoded = jwt.verify(token, process.env.JWT_SECRET);
    if (!decoded) {
      return res.status(401).json({ message: "Invalid or expired token" });
    }

    // Найдем карту пациента для клиента
    const patientCard = await PatientCard.findOne({
      where: { id: cardId },
    });
    if (!patientCard) {
      return res
        .status(404)
        .json({ message: "Patient card not found for this client" });
    }

    // Получаем все визиты для карты пациента
    const visits = await Visit.findAll({
      where: { patientCardId: patientCard.id },
      include: [
        {
          model: PatientCard,
          as: "patientCard",
        },
        {
          model: Doctor,
          as: "doctor",
          attributes: ["firstName", "lastName", "patronymic", "specialty"], // Возвращаем только нужные поля
        },
      ],
    });

    // Возвращаем список визитов клиента
    return res.status(200).json({ visits });
  } catch (error) {
    console.error(error);
    return res.status(500).json({ message: "Server error" });
  }
};

// Функции для создания графика визитов
const generateTimeSlots = (startTime, endTime, interval = 30) => {
  const slots = [];
  let currentTime = new Date(`1970-01-01T${startTime}:00`);
  const end = new Date(`1970-01-01T${endTime}:00`);

  while (currentTime <= end) {
    const time = currentTime.toTimeString().slice(0, 5); // Формат HH:MM
    slots.push(time);
    currentTime.setMinutes(currentTime.getMinutes() + interval);
  }
  return slots;
};

const getVisitsByDate = async (date) => {
  return Visit.findAll({
    where: { visitDate: date },
    include: [
      {
        model: Doctor,
        as: "doctor",
        attributes: ["id", "firstName", "lastName", "patronymic" || null],
      },
    ],
  });
};

const generateSchedule = async (date) => {
  const timeSlots = generateTimeSlots("09:00", "17:30"); // Генерация времени с шагом в 30 минут
  const visits = await getVisitsByDate(date); // Получаем визиты на выбранную дату

  const doctors = await Doctor.findAll({
    attributes: ["id", "firstName", "lastName", "patronymic"],
    where: { isDeleted: false },
  });

  // Инициализация расписания для всех врачей
  const doctorSchedules = {};
  doctors.forEach((doctor) => {
    const doctorKey = `${doctor.id}-${doctor.firstName} ${doctor.lastName} ${
      doctor.patronymic || ""
    }`.trim(); // Добавляем отчество, если оно есть
    doctorSchedules[doctorKey] = timeSlots.map((slot) => ({
      time: slot,
      status: "available",
    }));
  });

  // Логика обработки визитов и обновления расписания
  visits.forEach((visit) => {
    const { id, firstName, lastName, patronymic } = visit.doctor;
    const doctorKey = `${id}-${firstName} ${lastName} ${
      patronymic || ""
    }`.trim();

    // Проверяем, есть ли уже расписание для этого врача
    if (!doctorSchedules[doctorKey]) {
      doctorSchedules[doctorKey] = timeSlots.map((slot) => ({
        time: slot,
        status: "available",
      }));
    }

    const schedule = doctorSchedules[doctorKey];

    // Преобразуем visitTime в формат HH:mm
    const formattedVisitTime = visit.visitTime.slice(0, 5); // Отрезаем секунды

    // Находим индекс времени визита в расписании
    const visitStartIndex = timeSlots.indexOf(formattedVisitTime);

    // Если время визита найдено в расписании
    if (visitStartIndex !== -1) {
      const visitDuration = visit.visitType === "Лечение" ? 2 : 1; // Определение продолжительности визита
      for (let i = 0; i < visitDuration; i++) {
        const slotIndex = visitStartIndex + i;
        if (slotIndex < schedule.length && schedule[slotIndex]) {
          schedule[slotIndex].status = "booked";
        }
      }
    }
  });

  return doctorSchedules;
};

export const getDoctorsSchedule = async (req, res) => {
  try {
    const { date } = req.params;

    if (!date) {
      return res.status(400).json({ message: "Date is required" });
    }

    const isValidDate = /^\d{4}-\d{2}-\d{2}$/.test(date);
    if (!isValidDate) {
      return res
        .status(400)
        .json({ message: "Invalid date format. Use YYYY-MM-DD." });
    }

    const schedule = await generateSchedule(date);

    // Если расписание пустое
    if (!Object.keys(schedule).length) {
      return res.status(200).json({ message: "No doctors or visits found." });
    }

    return res.status(200).json(schedule);
  } catch (error) {
    console.error(error);
    return res.status(500).json({ message: "Server error" });
  }
};

export const getPatientCards = async (req, res) => {
  try {
    // Извлекаем токен из заголовков
    const token = req.headers.authorization?.split(" ")[1];
    if (!token) {
      return res.status(401).json({ message: "Токен отсутствует" });
    }

    // Проверяем токен и извлекаем роль пользователя
    const decoded = jwt.verify(token, process.env.JWT_SECRET);
    if (decoded.role === "client") {
      return res.status(403).json({ message: "Доступ запрещен" });
    }

    // Текущая дата для сравнения
    const today = dayjs().format("YYYY-MM-DD");

    // Загружаем данные о пациентах
    const patientCards = await PatientCard.findAll({
      attributes: [
        "id",
        "firstName",
        "lastName",
        "patronymic",
        "phoneNumber",
        "dateOfBirth", // Добавляем дату рождения
      ],
      include: [
        {
          model: Visit,
          as: "visits",
          attributes: ["visitDate", "visitTime"],
          required: false, // Включаем пациентов без визитов
          where: {
            visitDate: {
              [Op.lte]: today, // Визиты на сегодня или раньше
            },
          },
          order: [
            ["visitDate", "DESC"],
            ["visitTime", "DESC"],
          ],
        },
      ],
    });

    // Преобразуем данные для вывода
    const result = patientCards.map((card) => {
      const lastVisit = card.visits?.[0]; // Последний визит, если есть
      return {
        id: card.id,
        fullName: `${card.lastName} ${card.firstName} ${
          card.patronymic || ""
        }`.trim(),
        phoneNumber: card.phoneNumber,
        dateOfBirth: card.dateOfBirth, // Добавляем дату рождения в результат
        lastVisit: lastVisit
          ? `${lastVisit.visitDate} ${lastVisit.visitTime}`
          : null, // Если визита нет, возвращаем null
      };
    });

    // Отправляем результат клиенту
    res.status(200).json(result);
  } catch (error) {
    console.error(error);
    res.status(500).json({ message: "Ошибка сервера" });
  }
};

export const getPatientProfile = async (req, res) => {
  try {
    // Получение токена из заголовка Authorization
    const authHeader = req.headers.authorization;
    const token = authHeader && authHeader.split(" ")[1];
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

    // // Проверяем роль пользователя
    // const allowedRoles = ["admin", "doctor", ];
    // if (!allowedRoles.includes(decoded.role)) {
    //   return res.status(403).json({ message: "Доступ запрещен" });
    // }

    // Получение ID карты пациента из параметров запроса
    const { patientCardId } = req.params;

    // Поиск карты пациента по ID
    const patientCard = await PatientCard.findOne({
      where: { id: patientCardId },
      attributes: [
        "id",
        "firstName",
        "lastName",
        "patronymic",
        "phoneNumber",
        "address",
        "dateOfBirth",
      ],
      include: [
        {
          model: User,
          as: "user", // Связь между PatientCard и User
          attributes: ["email", "lastLogin", "avatar"], // Добавляем avatar
        },
      ],
    });

    if (!patientCard || !patientCard.user) {
      return res
        .status(404)
        .json({ message: "Карта пациента или пользователь не найдены" });
    }

    // Форматируем дату рождения
    const dateOfBirthFormatted = patientCard.dateOfBirth
      ? dayjs(patientCard.dateOfBirth).format("DD.MM.YYYY")
      : "Не указана";

    // Форматируем дату последнего входа
    const lastLoginFormatted = patientCard.user.lastLogin
      ? dayjs(patientCard.user.lastLogin).format("DD.MM.YYYY HH:mm")
      : "Неизвестно";

    // Формирование профиля пациента
    const profile = {
      fullName: `${patientCard.lastName} ${patientCard.firstName} ${
        patientCard.patronymic || ""
      }`.trim(),
      dateOfBirth: dateOfBirthFormatted,
      phoneNumber: patientCard.phoneNumber || "Не указан",
      address: patientCard.address || "Не указан",
      email: patientCard.user.email || "Не указан",
      lastLogin: lastLoginFormatted,
      avatar:
        patientCard.user.avatar ||
        "/backend/uploads/avatars/default_avatar.png", // Добавляем аватар
    };

    return res.status(200).json({ profile });
  } catch (error) {
    console.error(
      "Ошибка при получении профиля пациента:",
      error.message,
      error.stack
    );
    return res.status(500).json({ message: "Ошибка сервера" });
  }
};

export const createPatientNote = async (req, res) => {
  try {
    // Получаем токен из заголовков
    const token = req.headers.authorization?.split(" ")[1];
    if (!token) {
      return res.status(401).json({ message: "Токен не предоставлен" });
    }

    // Декодируем токен и получаем id пользователя
    let decoded;
    try {
      decoded = jwt.verify(token, process.env.JWT_SECRET);
    } catch (err) {
      return res.status(401).json({ message: "Неверный или истёкший токен" });
    }

    const userId = decoded.id;

    // Проверяем, что пользователь — доктор
    const doctor = await Doctor.findOne({ where: { userId } });
    if (!doctor) {
      return res
        .status(403)
        .json({ message: "Только доктора могут создавать примечания" });
    }

    // Получаем данные из тела запроса
    const { name, description, importance } = req.body;
    const patientCardId = req.params.patientCardId;

    // Проверяем, что все необходимые данные присутствуют
    if (!patientCardId || !name || !description) {
      return res
        .status(400)
        .json({ message: "Все поля должны быть заполнены" });
    }

    // Создаем примечание
    const newNote = await PatientNote.create({
      patientCardId,
      doctorId: doctor.id, // Подставляем id доктора
      name,
      description,
      importance,
    });

    return res
      .status(201)
      .json({ message: "Примечание успешно создано", note: newNote });
  } catch (error) {
    console.error("Ошибка при создании примечания:", error);
    return res.status(500).json({ message: "Ошибка сервера" });
  }
};

export const getPatientNotes = async (req, res) => {
  try {
    const { patientCardId } = req.params; // Получаем ID карты пациента из параметров запроса

    if (!patientCardId) {
      return res.status(400).json({ message: "ID карты пациента обязателен" });
    }

    // Ищем все примечания, связанные с указанной картой пациента
    const notes = await PatientNote.findAll({
      where: { patientCardId },
      include: [
        {
          model: Doctor,
          as: "doctor", // Связь с доктором, подставляем его данные в ответ
          attributes: ["firstName", "lastName", "patronymic", "specialty"], // Можно указать нужные поля доктора
        },
      ],
      order: [["createdAt", "DESC"]], // Сортируем по дате создания (по убыванию)
    });

    if (notes.length === 0) {
      return res.status(404).json({ message: "Примечания не найдены" });
    }

    return res.status(200).json({ notes });
  } catch (error) {
    console.error("Ошибка при получении примечаний:", error);
    return res.status(500).json({ message: "Ошибка сервера" });
  }
};

export const getWeeklySchedule = async (req, res) => {
  try {
    const { startDate, endDate } = req.params;

    // Проверка, что даты переданы
    if (!startDate || !endDate) {
      return res
        .status(400)
        .json({ message: "Пожалуйста, укажите даты начала и конца недели." });
    }

    // Проверка валидности формата дат
    const isValidStartDate = /^\d{4}-\d{2}-\d{2}$/.test(startDate);
    const isValidEndDate = /^\d{4}-\d{2}-\d{2}$/.test(endDate);

    if (!isValidStartDate || !isValidEndDate) {
      return res
        .status(400)
        .json({ message: "Неверный формат дат. Используйте YYYY-MM-DD." });
    }

    // Получение визитов за указанный период
    const visits = await Visit.findAll({
      where: {
        visitDate: {
          [Op.between]: [startDate, endDate], // Промежуток времени
        },
      },
      include: [
        {
          model: Doctor,
          as: "doctor", // Псевдоним, указанный в ассоциации
          attributes: ["id", "firstName", "lastName", "patronymic"], // Поля доктора
        },
      ],
      order: [
        ["visitDate", "ASC"],
        ["visitTime", "ASC"],
      ], // Сортировка по дате и времени
    });

    // Формирование расписания
    const schedule = {};

    visits.forEach((visit) => {
      const doctorKey = `${visit.doctor.id}-${visit.doctor.firstName} ${
        visit.doctor.lastName
      } ${visit.doctor.patronymic || ""}`.trim(); // Учет отчества врача
      const visitDate = visit.visitDate;

      // Инициализация структуры для врача и даты
      if (!schedule[doctorKey]) schedule[doctorKey] = {};
      if (!schedule[doctorKey][visitDate]) schedule[doctorKey][visitDate] = [];

      // Добавление информации о визите
      schedule[doctorKey][visitDate].push({
        time: visit.visitTime.slice(0, 5), // Форматируем время HH:mm
        type: visit.visitType,
        status: visit.visitStatus,
      });
    });

    // Проверка, есть ли данные для возврата
    if (Object.keys(schedule).length === 0) {
      return res
        .status(200)
        .json({ message: "Визиты на указанную неделю отсутствуют." });
    }

    return res.status(200).json(schedule);
  } catch (error) {
    console.error("Ошибка при получении расписания:", error);
    return res.status(500).json({ message: "Ошибка сервера" });
  }
};

export const getMonthlySchedule = async (req, res) => {
  try {
    const { month } = req.params;

    // Проверка, что месяц передан и имеет корректный формат
    if (!month || !/^\d{4}-\d{2}$/.test(month)) {
      return res.status(400).json({
        message: "Пожалуйста, укажите месяц в формате YYYY-MM.",
      });
    }

    // Определение начала и конца месяца
    const startDate = `${month}-01`;
    const endDate = new Date(
      new Date(startDate).getFullYear(),
      new Date(startDate).getMonth() + 1,
      0
    )
      .toISOString()
      .slice(0, 10); // Конец месяца в формате YYYY-MM-DD

    // Получение всех записей за указанный месяц
    const visits = await Visit.findAll({
      where: {
        visitDate: {
          [Op.between]: [startDate, endDate],
        },
      },
      include: [
        {
          model: Doctor,
          as: "doctor",
          attributes: ["id", "firstName", "lastName", "patronymic"], // Указаны все необходимые поля врача
        },
      ],
      order: [
        ["visitDate", "ASC"],
        ["visitTime", "ASC"],
      ], // Сортировка по дате и времени
    });

    // Формирование расписания
    const schedule = {};

    visits.forEach((visit) => {
      const visitDate = visit.visitDate;
      const doctorName = `${visit.doctor.firstName} ${visit.doctor.lastName} ${
        visit.doctor.patronymic || ""
      }`.trim(); // Формируем ФИО врача с учетом отчества

      if (!schedule[visitDate]) {
        schedule[visitDate] = {};
      }

      if (!schedule[visitDate][doctorName]) {
        schedule[visitDate][doctorName] = 0;
      }

      schedule[visitDate][doctorName] += 1; // Увеличиваем счетчик записей
    });

    // Проверка на отсутствие записей
    if (Object.keys(schedule).length === 0) {
      return res
        .status(200)
        .json({ message: "Записи на указанный месяц отсутствуют." });
    }

    return res.status(200).json(schedule);
  } catch (error) {
    console.error("Ошибка при получении расписания на месяц:", error);
    return res.status(500).json({ message: "Ошибка сервера" });
  }
};

export const createSnapshot = async (req, res) => {
  try {
    // Проверка, загрузился ли файл
    if (!req.file) {
      return res.status(400).json({ message: "Файл снимка обязателен" });
    }

    const { visitId, patientCardId, toothNumbers, note } = req.body;

    // Проверка существования визита
    const visit = await Visit.findByPk(visitId);
    if (!visit) {
      // Удаление загруженного файла при ошибке
      await fs.unlink(req.file.path);
      return res.status(404).json({ message: "Указанный визит не найден" });
    }

    // Проверка существования карты пациента
    const patientCard = await PatientCard.findByPk(patientCardId);
    if (!patientCard) {
      // Удаление загруженного файла при ошибке
      await fs.unlink(req.file.path);
      return res
        .status(404)
        .json({ message: "Указанная карта пациента не найдена" });
    }

    // Преобразование пути к файлу
    const snapshotPath = `/backend/${req.file.path.replace(/\\/g, "/")}`;

    // Создание снимка
    const snapshot = await Snapshot.create({
      visitId,
      patientCardId,
      snapshotFile: snapshotPath, // Сохраняем преобразованный путь
      toothNumbers, // Сохраняем как строку
      note,
    });

    return res.status(201).json({ message: "Снимок успешно создан", snapshot });
  } catch (error) {
    console.error("Ошибка при создании снимка:", error);

    // Удаление загруженного файла при ошибке
    if (req.file) {
      await fs.unlink(req.file.path);
    }

    return res
      .status(500)
      .json({ message: "Ошибка сервера", error: error.message });
  }
};

export const getSnapshotsByPatientCard = async (req, res) => {
  try {
    // Получение patientCardId из параметров запроса
    const { patientCardId } = req.params;

    // Получаем все снимки, связанные с данным patientCardId
    const snapshots = await Snapshot.findAll({
      where: { patientCardId }, // Фильтруем по patientCardId
      include: [
        {
          model: Visit,
          as: "visit", // Ассоциация с моделью Visit
          attributes: ["id"], // Только ID визита
        },
        {
          model: PatientCard,
          as: "patientCard", // Ассоциация с моделью PatientCard
          attributes: ["id"], // Мы уже фильтруем по patientCardId, поэтому больше ничего не нужно
        },
      ],
    });

    if (!snapshots || snapshots.length === 0) {
      return res
        .status(404)
        .json({ message: "Снимки не найдены для данного пациента" });
    }

    // Формируем массив снимков с необходимыми данными
    const snapshotsData = snapshots.map((snapshot) => ({
      id: snapshot.id, // ID снимка
      createdAt: snapshot.createdAt, // Дата загрузки
      snapshotFile: snapshot.snapshotFile, // Путь к снимку
      visit: snapshot.visit.id, // ID визита
      toothNumbers: snapshot.toothNumbers, // Зубы
      note: snapshot.note, // Описание
    }));

    return res.status(200).json({ snapshots: snapshotsData });
  } catch (error) {
    console.error("Ошибка при получении снимков:", error);
    return res
      .status(500)
      .json({ message: "Ошибка сервера", error: error.message });
  }
};

export const updateTeethStatuses = async (req, res) => {
  const { patientCardId } = req.params; // Получение patientCardId из параметров
  const { teeth } = req.body; // Получение данных о зубах из тела запроса

  if (!patientCardId || !Array.isArray(teeth)) {
    return res
      .status(400)
      .json({ message: "Укажите корректный patientCardId и массив teeth" });
  }

  try {
    for (const { toothNumber, statuses } of teeth) {
      if (!toothNumber) {
        return res.status(400).json({
          message: "Каждый зуб должен содержать toothNumber",
        });
      }

      // Находим зуб
      const tooth = await Tooth.findOne({
        where: { patientCardId, toothNumber },
        include: { model: ToothStatus, as: "statuses" },
      });

      if (!tooth) {
        return res.status(404).json({
          message: `Зуб с номером ${toothNumber} не найден для карты пациента ${patientCardId}`,
        });
      }

      // Удаляем текущие статусы зуба
      await ToothStatus.destroy({ where: { toothId: tooth.id } });

      // Если статусы переданы, создаём новые записи
      if (statuses && Array.isArray(statuses) && statuses.length > 0) {
        const newStatuses = statuses.map((status) => ({
          toothId: tooth.id,
          status,
        }));

        await ToothStatus.bulkCreate(newStatuses);
      }
    }

    res.status(200).json({ message: "Статусы зубов обновлены успешно" });
  } catch (error) {
    console.error("Ошибка при обновлении статусов зубов:", error);
    res.status(500).json({ message: "Ошибка сервера", error: error.message });
  }
};

export const getTeethWithStatuses = async (req, res) => {
  const { patientCardId } = req.params; // Получение patientCardId из параметров

  if (!patientCardId) {
    return res
      .status(400)
      .json({ message: "Укажите patientCardId в параметрах" });
  }

  try {
    // Получение всех зубов с их статусами
    const teeth = await Tooth.findAll({
      where: { patientCardId },
      include: {
        model: ToothStatus,
        as: "statuses",
        attributes: ["status"], // Возвращаем только поле "status" из статусов
      },
    });

    if (!teeth || teeth.length === 0) {
      return res.status(404).json({
        message: `Зубы для карты пациента с ID ${patientCardId} не найдены`,
      });
    }

    res.status(200).json(teeth);
  } catch (error) {
    console.error("Ошибка при получении зубов:", error);
    res.status(500).json({ message: "Ошибка сервера", error: error.message });
  }
};

export const addExaminationSheet = async (req, res) => {
  const { patientCardId } = req.params;
  const {
    type,
    complaints,
    preliminaryDiagnosis,
    doctorRecommendations,
    conditionDynamics,
    treatmentResults,
    cleaningGoal,
    cleaningProcedure,
    additionalCleaningProcedures,
    postCleaningCondition,
    problemDescription,
    conditionAssessment,
    additionalDetails,
    measuresTaken,
  } = req.body;

  try {
    // Проверка обязательных полей
    if (!patientCardId || !type) {
      return res.status(400).json({
        message: "Необходимо указать patientCardId и type",
      });
    }

    // Валидация типа осмотра
    const validTypes = [
      "Первичный осмотр",
      "Повторный визит",
      "Профилактическая чистка",
      "Экстренный случай",
    ];
    if (!validTypes.includes(type)) {
      return res.status(400).json({
        message: `Недопустимый тип осмотра. Допустимые значения: ${validTypes.join(
          ", "
        )}`,
      });
    }

    // Проверка обязательных полей для каждого типа
    const requiredFieldsByType = {
      "Первичный осмотр": [
        "complaints",
        "preliminaryDiagnosis",
        "doctorRecommendations",
      ],
      "Повторный визит": ["conditionDynamics", "treatmentResults"],
      "Профилактическая чистка": [
        "cleaningGoal",
        "cleaningProcedure",
        "postCleaningCondition",
      ],
      "Экстренный случай": [
        "problemDescription",
        "conditionAssessment",
        "measuresTaken",
        "doctorRecommendations",
      ],
    };

    const missingFields = requiredFieldsByType[type].filter(
      (field) => !req.body[field]
    );

    if (missingFields.length > 0) {
      return res.status(400).json({
        message: `Для типа "${type}" необходимо указать следующие поля: ${missingFields.join(
          ", "
        )}`,
      });
    }

    // Создание записи
    const examinationSheet = await ExaminationSheet.create({
      patientCardId,
      type,
      complaints,
      preliminaryDiagnosis,
      doctorRecommendations,
      conditionDynamics,
      treatmentResults,
      cleaningGoal,
      cleaningProcedure,
      additionalCleaningProcedures,
      postCleaningCondition,
      problemDescription,
      conditionAssessment,
      additionalDetails,
      measuresTaken,
    });

    res.status(201).json({
      message: "Запись успешно добавлена",
      examinationSheet,
    });
  } catch (error) {
    console.error("Ошибка при добавлении записи в лист осмотра:", error);
    res.status(500).json({
      message: "Ошибка сервера",
      error: error.message,
    });
  }
};

export const getExaminationSheets = async (req, res) => {
  const { patientCardId } = req.params;

  try {
    if (!patientCardId) {
      return res
        .status(400)
        .json({ message: "Необходимо указать patientCardId" });
    }

    // Получение всех записей для указанной карты пациента
    const sheets = await ExaminationSheet.findAll({
      where: { patientCardId },
      attributes: [
        "id",
        "type",
        "createdAt",
        "complaints",
        "preliminaryDiagnosis",
        "doctorRecommendations",
        "conditionDynamics",
        "treatmentResults",
        "cleaningGoal",
        "cleaningProcedure",
        "additionalCleaningProcedures",
        "postCleaningCondition",
        "problemDescription",
        "conditionAssessment",
        "additionalDetails",
        "measuresTaken",
      ],
    });

    // Группировка записей по типу
    const groupedSheets = {
      "Первичный осмотр": [],
      "Повторный визит": [],
      "Профилактическая чистка": [],
      "Экстренный случай": [],
    };

    sheets.forEach((sheet) => {
      groupedSheets[sheet.type].push(sheet);
    });

    // Формирование упрощенного списка с сортировкой по дате
    const simplifiedSheets = await ExaminationSheet.findAll({
      where: { patientCardId },
      attributes: ["id", "type", "createdAt"],
      order: [["createdAt", "ASC"]], // Сортировка по дате создания
    });

    res.status(200).json({
      message: "Записи успешно получены",
      data: {
        grouped: groupedSheets,
        simplified: simplifiedSheets,
      },
    });
  } catch (error) {
    console.error("Ошибка при получении записей листа осмотра:", error);
    res.status(500).json({
      message: "Ошибка сервера",
      error: error.message,
    });
  }
};

export const getPatientCardDetails = async (req, res) => {
  const { patientCardId } = req.params;

  try {
    if (!patientCardId) {
      return res
        .status(400)
        .json({ message: "Необходимо указать patientCardId" });
    }

    // Получение данных карты пациента
    const patientCard = await PatientCard.findOne({
      where: { id: patientCardId },
      attributes: ["policyNumber", "snils", "passport"], // Выбор только нужных полей
    });

    if (!patientCard) {
      return res.status(404).json({ message: "Карта пациента не найдена" });
    }

    res.status(200).json(patientCard);
  } catch (error) {
    console.error("Ошибка при получении данных карты пациента:", error);
    res.status(500).json({ message: "Ошибка сервера", error: error.message });
  }
};

export const deletePatientCard = async (req, res) => {
  const { patientCardId } = req.params;
  const { role } = req.user;

  try {
    if (role !== "admin") {
      return res
        .status(403)
        .json({ message: "Доступ запрещен. Необходима роль admin" });
    }

    if (!patientCardId) {
      return res
        .status(400)
        .json({ message: "Необходимо указать patientCardId" });
    }

    // Поиск карты пациента с данными пользователя
    const patientCard = await PatientCard.findOne({
      where: { id: patientCardId },
      include: [{ model: User, as: "user" }],
    });

    if (!patientCard) {
      return res.status(404).json({ message: "Карта пациента не найдена" });
    }

    const userId = patientCard.user.id; // ID связанного пользователя

    // Удаление карты пациента
    await patientCard.destroy();

    // Удаление пользователя
    await User.destroy({ where: { id: userId } });

    res.status(200).json({
      message: "Карта пациента и связанный пользователь успешно удалены",
    });
  } catch (error) {
    console.error("Ошибка при удалении карты пациента и пользователя:", error);
    res.status(500).json({ message: "Ошибка сервера", error: error.message });
  }
};

export const createOrUpdateSurvey = async (req, res) => {
  try {
    const { patientCardId, ...surveyData } = req.body;

    if (!patientCardId) {
      return res
        .status(400)
        .json({ message: "Отсутствует идентификатор пациента" });
    }

    let survey = await MedicalSurvey.findOne({ where: { patientCardId } });

    if (survey) {
      await survey.update(surveyData);
      return res.status(200).json({ message: "Анкета обновлена", survey });
    }

    survey = await MedicalSurvey.create({ patientCardId, ...surveyData });
    res.status(201).json({ message: "Анкета создана", survey });
  } catch (error) {
    console.error("Ошибка при сохранении анкеты:", error);
    res.status(500).json({ message: "Ошибка сервера" });
  }
};

export const getSurveyByPatient = async (req, res) => {
  try {
    const { patientCardId } = req.params;

    const survey = await MedicalSurvey.findOne({ where: { patientCardId } });

    if (!survey) {
      return res.status(404).json({ message: "Анкета не найдена" });
    }

    res.status(200).json(survey);
  } catch (error) {
    console.error("Ошибка при получении анкеты:", error);
    res.status(500).json({ message: "Ошибка сервера" });
  }
};

export const getAllDoctors = async (req, res) => {
  try {
    const doctors = await Doctor.findAll({
      attributes: [
        [
          fn(
            "concat",
            col("lastName"),
            " ",
            col("firstName"),
            " ",
            col("patronymic")
          ),
          "fullName",
        ],
        "specialty",
      ],
      where: { isDeleted: false },
    });

    res.json(doctors);
  } catch (error) {
    console.error("Ошибка при получении списка врачей:", error);
    res.status(500).json({ error: "Ошибка сервера" });
  }
};
