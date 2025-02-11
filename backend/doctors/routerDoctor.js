import { Router } from "express";
import { body } from "express-validator";
import controllerDoctor from "./controllerDoctor.js"; // Импортируем контроллер для создания врача

const doctorRouter = Router();

// Роут для создания врача с пользователем
doctorRouter.post(
  "/create",
  [
    body("mobilePhone")
      .matches(/^\+7\s\(\d{3}\)\s\d{3}-\d{2}-\d{2}$/)
      .withMessage("Номер телефона должен быть в формате +7 (999) 123-45-67"),
  ],
  controllerDoctor.createDoctor
);
doctorRouter.get("/profile", controllerDoctor.getDoctorInfo);
doctorRouter.get("/shudle", controllerDoctor.getDoctorVisits);
doctorRouter.get("/get/all", controllerDoctor.getAllDoctors);
doctorRouter.get("/profile/:doctorId", controllerDoctor.getDoctorInfoById);
doctorRouter.get("/shudle/:doctorId", controllerDoctor.getDoctorVisitsById);
doctorRouter.post("/avatar/upload", controllerDoctor.uploadDoctorAvatar);

export default doctorRouter;
