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
app.use(bodyParser.urlencoded({ extended: true })); // Для обработки form-data

// Подключение маршрутов
app.use("/api/users", authRouter); // Все маршруты авторизации будут начинаться с /api/auth
app.use("/api/patient-cards", PatientCardRouter);
app.use("/api/doctors", doctorRouter);
app.use("/api/admin", adminRouter);
app.use("/uploads", express.static("uploads"));

// Синхронизация моделей и запуск сервера
dbST.sync({ alter: true }).then(() => {
  app.listen(PORT, () => {
    console.log(`Server is running on http://localhost:${PORT}`);
    console.log(`Синхронизация моделей завершена`);
  });
});
// тестовая строка
