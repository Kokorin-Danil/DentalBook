import { Router } from "express";
import {
  createAdminUser,
  getAllDoctors,
  getAllPatients,
  updatePatientAvatar,
  updatePatientData,
} from "./controllerAdmin.js";
import { authenticateToken } from "../utils/authMiddleware.js";
import { uploadAvatar } from "../utils/middleware.js";

const adminRouter = Router();

adminRouter.post("/create/admin", createAdminUser);
adminRouter.get("/doctors/get", authenticateToken, getAllDoctors);
adminRouter.get("/patients/get", authenticateToken, getAllPatients);
adminRouter.put(
  "/patients/avatar/update/:patientCardId",
  authenticateToken,
  uploadAvatar.single("avatar"), // Применяем middleware для обработки аватарки
  updatePatientAvatar // Контроллер для обновления аватарки
);
adminRouter.put(
  "/patients/data/update/:patientCardId",
  authenticateToken,
  updatePatientData
);

export default adminRouter;
