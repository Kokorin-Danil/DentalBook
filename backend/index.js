import express from "express";
import dbST from "./utils/database.js";
import bodyParser from "body-parser";
import authRouter from "./users/routerUser.js";
import User from "./users/modelUser.js";
import Doctor from "./doctors/modelDoctor.js";
import PatientCardRouter from "./patientCard/patientCardRouter.js";
import doctorRouter from "./doctors/routerDoctor.js";
import cors from "cors";
import adminRouter from "./admin/routerAdmin.js";

const app = express();
app.use(cors());
const PORT = 3003;

// Маршрут для теста сервера
app.use(bodyParser.json()); // Для обработки JSON-запросов

// Подключение маршрутов
app.use("/api/users", authRouter); // Все маршруты авторизации будут начинаться с /api/auth
app.use("/api/patient-cards", PatientCardRouter);
app.use("/api/doctors", doctorRouter);
app.use("/api/admin", adminRouter);
app.use("/uploads", express.static("uploads"));

// async function createUser() {
//   try {
//     const email = "kokorindanil474@gmail.com"; // Укажите email
//     const password = "1234"; // Укажите пароль
//     const role = "doctor"; // Укажите роль (можно "admin", "doctor", "client")

//     // Проверяем, существует ли уже пользователь с таким email
//     const existingUser = await User.findOne({ where: { email } });
//     if (existingUser) {
//       console.log("Пользователь с таким email уже существует");
//       return;
//     }

//     // Создаем нового пользователя
//     const newUser = await User.create({
//       email,
//       password: password,
//       role,
//       firstName: 'Данил',
//       lastName: 'Кокорин'
//     });

//     console.log("Пользователь успешно создан:");
//     console.log(newUser);
//   } catch (error) {
//     console.error("Ошибка при создании пользователя:", error);
//   } finally {
//     // Закрытие соединения с базой данных
//     await dbST.close();
//   }
// }

// const create = createUser();

// const createDoctorWithUser = async () => {
//   try {
//     // Создание пользователя
//     const user = await User.create({
//       email: "doctor@example.com",
//       password: "1234", // Пройдет через хук хэширования
//       role: "doctor",
//     });

//     // Создание врача и связывание с пользователем
//     const doctor = await Doctor.create({
//       firstName: "John",
//       lastName: "Doe",
//       email: "doctor@example.com",
//       specialty: "Dentist",
//       userId: user.id, // Ссылка на пользователя
//     });

//     console.log("Doctor created:", doctor);
//   } catch (error) {
//     console.error("Error creating doctor:", error);
//   }
// };

// createDoctorWithUser();

// const create = createDoctorWithUser;

// Синхронизация моделей и запуск сервера
dbST.sync({ alter: true }).then(() => {
  app.listen(PORT, () => {
    console.log(`Server is running on http://localhost:${PORT}`);
    console.log(`Синхронизация моделей завершена`);
  });
});
// тестовая строка
