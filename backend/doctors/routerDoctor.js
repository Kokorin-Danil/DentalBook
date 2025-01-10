import { Router } from "express";
import controllerDoctor from "./controllerDoctor.js"; // Импортируем контроллер для создания врача

const doctorRouter = Router();

// Роут для создания врача с пользователем
doctorRouter.post("/create", controllerDoctor.createDoctor);
doctorRouter.get("/profile", controllerDoctor.getDoctorInfo);

export default doctorRouter;
