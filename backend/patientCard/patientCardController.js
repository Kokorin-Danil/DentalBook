import { PatientCard, Visit, PatientNote } from "./modelPatientCard.js";
import User from "../users/modelUser.js";
import jwt from "jsonwebtoken";
import dotenv from "dotenv";
import crypto from "crypto";
import Doctor from "../doctors/modelDoctor.js";
import { Op } from "sequelize";
import dayjs from "dayjs";

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

    if (decoded.role !== "doctor") {
      return res.status(403).json({
        message: "Доступ запрещен. Только врачи могут создавать карты.",
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

  // Формируем строку даты и времени для проверки
  const visitDateTimeString = `${visitDate}T${visitTime}:00`; // Получаем строку: '2024-12-28T16:00:00'
  console.log("Generated date string:", visitDateTimeString);

  // Преобразуем строку в объект dayjs для даты и времени
  const visitStartTime = dayjs(visitDateTimeString);
  console.log("Visit start time:", visitStartTime.format());

  if (!visitStartTime.isValid()) {
    return res.status(400).json({ message: "Invalid visit time" });
  }

  try {
    // Проверка наличия токена в заголовке Authorization
    const token = req.headers.authorization?.split(" ")[1];
    if (!token) {
      return res
        .status(401)
        .json({ message: "Authorization token is missing" });
    }

    // Верификация JWT токена
    const decoded = jwt.verify(token, JWT_SECRET);
    if (!decoded) {
      return res.status(401).json({ message: "Invalid or expired token" });
    }

    // Проверяем роль пользователя (если требуется)
    const user = await User.findByPk(decoded.id);
    if (!user || !(user.role === "admin" || user.role === "doctor")) {
      return res.status(403).json({
        message: "Access denied, only admins or doctors can create visits",
      });
    }

    // Извлекаем данные из тела запроса
    const { doctorFullName, patientFullName, visitType } = req.body;

    // Поиск врача по полному ФИО
    const doctor = await Doctor.findOne({
      where: {
        firstName: doctorFullName.split(" ")[0],
        lastName: doctorFullName.split(" ")[1],
      },
    });
    if (!doctor) {
      return res.status(404).json({ message: "Doctor not found" });
    }
    const [patientLastName, patientFirstName, patientPatronymic] =
      patientFullName.split(" ");
    const patientCard = await PatientCard.findOne({
      where: {
        firstName: patientFirstName,
        lastName: patientLastName,
        patronymic: patientPatronymic || null, // Учет отчества, если указано
      },
    });
    if (!patientCard) {
      return res.status(404).json({ message: "Patient not found" });
    }

    // Определяем длительность визита в зависимости от типа визита
    let visitDuration;
    if (visitType === "лечение") {
      visitDuration = 60; // 1 час для лечения
    } else if (visitType === "осмотр" || visitType === "консультация") {
      visitDuration = 30; // 30 минут для осмотра и консультации
    } else {
      return res.status(400).json({ message: "Invalid visit type" });
    }

    // Преобразуем время окончания визита
    const visitEndTime = visitStartTime.add(visitDuration, "minute");
    console.log("Visit start time:", visitStartTime.format());
    console.log("Visit end time:", visitEndTime.format());

    // Проверка на пересечение времени визитов, учитывая длительность визита
    const existingVisit = await Visit.findOne({
      where: {
        doctorId: doctor.id,
        visitDate, // Сравниваем только дату
        [Op.and]: [
          {
            // Проверяем, что существующий визит не заканчивается раньше, чем новый начинается
            visitTime: {
              [Op.lt]: visitEndTime.format("HH:mm:ss"),
            },
          },
          {
            // Проверяем, что существующий визит не начинается позже, чем новый заканчивается
            visitTime: {
              [Op.gte]: visitStartTime.format("HH:mm:ss"),
            },
          },
        ],
      },
    });

    // Если визит пересекается, вернуть ошибку
    if (existingVisit) {
      return res
        .status(400)
        .json({ message: "The doctor already has a visit at this time" });
    }

    // Теперь нужно учитывать "лечение", которое занимает 1 час.
    // Проверим, если уже есть запись типа "лечение", что следующее время не перекрывает его.

    if (visitType !== "лечение") {
      // Если новый визит - не лечение, проверяем, есть ли существующая запись типа "лечение"
      const existingTreatmentVisit = await Visit.findOne({
        where: {
          doctorId: doctor.id,
          visitDate,
          visitType: "лечение", // Ищем визит типа "лечение"
          [Op.or]: [
            {
              visitTime: {
                [Op.lte]: visitStartTime.format("HH:mm:ss"),
              },
            },
            {
              visitTime: {
                [Op.gte]: visitEndTime.format("HH:mm:ss"),
              },
            },
          ],
        },
      });

      if (existingTreatmentVisit) {
        // Если существует визит типа "лечение", который накладывается
        const treatmentEndTime = dayjs(
          `${visitDate}T${existingTreatmentVisit.visitTime}:00`
        ).add(60, "minute"); // Добавляем 1 час к времени окончания визита

        if (visitStartTime.isBefore(treatmentEndTime)) {
          return res.status(400).json({
            message: `The doctor already has a treatment visit that ends at ${treatmentEndTime.format(
              "HH:mm:ss"
            )}, and the next visit can only start after ${treatmentEndTime
              .add(30, "minute")
              .format("HH:mm:ss")}`,
          });
        }
      }
    }

    // Создание нового визита
    const newVisit = await Visit.create({
      patientCardId: patientCard.id,
      doctorId: doctor.id,
      visitType,
      visitDate, // Храним только дату
      visitTime: visitStartTime.format("HH:mm:ss"), // Храним только время
    });

    // Возвращаем успешно созданный визит
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
    const { visitId, newStatus } = req.body;

    // Проверяем, что статус визита является допустимым
    const validStatuses = ["не подтвержден", "подтвержден", "отменен"];
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
          attributes: ["firstName", "lastName", "specialty"], // Возвращаем только нужные поля
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
        attributes: ["id", "firstName", "lastName"],
      },
    ],
  });
};

const generateSchedule = async (date) => {
  const timeSlots = generateTimeSlots("09:00", "17:30"); // Генерация времени с шагом в 30 минут
  const visits = await getVisitsByDate(date); // Получаем визиты на выбранную дату

  const doctors = await Doctor.findAll({
    attributes: ["id", "firstName", "lastName"],
  });

  // Инициализация расписания для всех врачей
  const doctorSchedules = {};
  doctors.forEach((doctor) => {
    const doctorKey = `${doctor.id}-${doctor.firstName} ${doctor.lastName}`;
    doctorSchedules[doctorKey] = timeSlots.map((slot) => ({
      time: slot,
      status: "available",
    }));
  });

  // Логика обработки визитов и обновления расписания
  visits.forEach((visit) => {
    const { id, firstName, lastName, visitTime, visitType } = visit.doctor;
    const doctorKey = `${id}-${firstName} ${lastName}`;

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

    // Логирование для отладки
    console.log(`Processing visit for doctor: ${doctorKey}`);
    console.log(`Visit time: ${formattedVisitTime}`);
    console.log(
      `Available slots:`,
      schedule.map((slot) => slot.time)
    );

    // Находим индекс времени визита в расписании
    const visitStartIndex = timeSlots.indexOf(formattedVisitTime);

    // Если время визита найдено в расписании
    if (visitStartIndex !== -1) {
      console.log(
        `Found visit time in the schedule at index: ${visitStartIndex}`
      );

      const visitDuration = visit.visitType === "лечение" ? 2 : 1; // Определение продолжительности визита
      for (let i = 0; i < visitDuration; i++) {
        const slotIndex = visitStartIndex + i;
        if (slotIndex < schedule.length && schedule[slotIndex]) {
          // Проверяем, не занят ли слот, если нет - меняем статус на "booked"
          if (schedule[slotIndex].status === "available") {
            console.log(`Booking slot at ${schedule[slotIndex].time}`);
            schedule[slotIndex].status = "booked";
          } else {
            console.log(
              `Slot at ${schedule[slotIndex].time} is already booked.`
            );
          }
        }
      }
    } else {
      console.log(`Visit time ${formattedVisitTime} not found in timeSlots.`);
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

export const getWeeklyVisits = async (req, res) => {
  try {
    const { date } = req.params; // Дата в формате 2024-12-27

    if (!dayjs(date).isValid()) {
      return res.status(400).json({ message: "Invalid date format" });
    }

    // Определяем начало и конец недели
    const inputDate = dayjs(date);
    const weekStart = inputDate.startOf("week").add(1, "day"); // Начало недели (понедельник)
    const weekEnd = inputDate.endOf("week").add(1, "day"); // Конец недели (воскресенье)

    // Получаем записи за указанную неделю
    const visits = await Visit.findAll({
      where: {
        visitDate: {
          [Op.between]: [
            weekStart.format("YYYY-MM-DD"),
            weekEnd.format("YYYY-MM-DD"),
          ],
        },
      },
      include: [
        {
          model: Doctor,
          as: "doctor", // Указываем alias, используемый в связи
          attributes: ["firstName", "lastName"], // Имя и фамилия врача
        },
      ],
    });

    // Группируем записи по датам и форматируем вывод
    const visitsByDay = {};

    visits.forEach((visit) => {
      const visitDate = visit.visitDate;
      const visitStartTime = dayjs(`${visitDate}T${visit.visitTime}`);
      const visitDuration = visit.visitType === "лечение" ? 60 : 30; // Определяем длительность визита
      const visitEndTime = visitStartTime.add(visitDuration, "minute");

      // Формируем строку дня недели
      const dayOfWeek = dayjs(visitDate).format("dddd"); // Пример: "понедельник"

      // Добавляем визит в соответствующий день
      if (!visitsByDay[visitDate]) {
        visitsByDay[visitDate] = {
          dayOfWeek,
          visits: [],
        };
      }

      visitsByDay[visitDate].visits.push({
        timeRange: `${visitStartTime.format("HH:mm")} - ${visitEndTime.format(
          "HH:mm"
        )}`,
        doctorName: `${visit.Doctor.lastName} ${visit.Doctor.firstName}`,
      });
    });

    // Формируем итоговый результат
    const result = Object.entries(visitsByDay).map(
      ([date, { dayOfWeek, visits }]) => ({
        date: `${date} (${dayOfWeek})`,
        visits,
      })
    );

    return res.status(200).json(result);
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
      attributes: ["id", "firstName", "lastName", "patronymic", "phoneNumber"],
      include: [
        {
          model: Visit,
          as: "visits",
          attributes: ["visitDate", "visitTime"],
          where: {
            visitDate: {
              [Op.lte]: today, // Исключаем визиты с датой больше текущей
            },
          },
          order: [
            ["visitDate", "DESC"],
            ["visitTime", "DESC"],
          ],
          limit: 1, // Последний визит
        },
      ],
    });

    // Преобразуем данные для вывода
    const result = patientCards.map((card) => {
      const lastVisit = card.visits[0]; // Последний визит
      return {
        id: card.id,
        fullName: `${card.lastName} ${card.firstName} ${
          card.patronymic || ""
        }`.trim(),
        phoneNumber: card.phoneNumber,
        lastVisit: lastVisit
          ? `${lastVisit.visitDate} ${lastVisit.visitTime}`
          : "Нет данных",
      };
    });

    res.status(200).json(result);
  } catch (error) {
    console.error(error);
    res.status(500).json({ message: "Ошибка сервера" });
  }
};

export const getPatientProfile = async (req, res) => {
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

    // Проверяем, что роль пользователя не "client"
    if (decoded.role === "client") {
      return res.status(403).json({ message: "Доступ запрещен" });
    }

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
        "policyNumber",
        "dateOfBirth",
      ],
      include: [
        {
          model: User,
          as: "user", // Предполагается связь между PatientCard и User
          attributes: ["email", "lastLogin"],
        },
      ],
    });

    if (!patientCard) {
      return res.status(404).json({ message: "Карта пациента не найдена" });
    }

    // Форматируем дату рождения
    const dateOfBirthFormatted = patientCard.dateOfBirth
      ? dayjs(patientCard.dateOfBirth).format("DD.MM.YYYY")
      : "Не указана";

    // Форматируем дату последнего входа
    const lastLoginFormatted = patientCard.user?.lastLogin
      ? dayjs(patientCard.user.lastLogin).format("DD.MM.YYYY HH:mm")
      : "Неизвестно";

    // Формирование профиля пациента
    const profile = {
      fullName: `${patientCard.lastName} ${patientCard.firstName} ${
        patientCard.patronymic || ""
      }`.trim(),
      dateOfBirth: dateOfBirthFormatted,
      policy: patientCard.policyNumber || "Не указан",
      phoneNumber: patientCard.phoneNumber || "Не указан",
      address: patientCard.address || "Не указан",
      email: patientCard.user?.email || "Не указан",
      lastLogin: lastLoginFormatted,
    };

    return res.status(200).json({ profile });
  } catch (error) {
    console.error("Ошибка при получении профиля пациента:", error);
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
    const { patientCardId, name, description, importance } = req.body;

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
          attributes: ["firstName", "lastName", "specialty"], // Можно указать нужные поля доктора
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
