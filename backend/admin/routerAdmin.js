import { Router } from "express";
import {
  createAdminUser,
  getAllDoctors,
  getAllPatients,
  updatePatientAvatar,
  updatePatientData,
  updateDoctorAvatar,
  updateDoctorData,
  deleteVisit,
  deletePatientNote,
  deleteSnapshot,
  createManager,
  deleteExaminationSheet,
  getAllManagers,
  deleteDoctor,
  deleteManager,
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
adminRouter.put(
  "/doctors/avatar/update/:doctorId",
  authenticateToken,
  uploadAvatar.single("avatar"),
  updateDoctorAvatar
);
adminRouter.put(
  "/doctors/data/update/:doctorId",
  authenticateToken,
  updateDoctorData
);
adminRouter.delete("/visit/:visitId", authenticateToken, deleteVisit);
adminRouter.delete(
  "/patientNote/:patientNoteId",
  authenticateToken,
  deletePatientNote
);
adminRouter.delete("/snapshot/:snapshotId", authenticateToken, deleteSnapshot);
adminRouter.post("/manager/create", authenticateToken, createManager);
adminRouter.delete(
  "/examination-sheet/:id",
  authenticateToken,
  deleteExaminationSheet
);
adminRouter.get("/manager/getall", authenticateToken, getAllManagers);
adminRouter.delete("/doctors/:doctorId", authenticateToken, deleteDoctor);
adminRouter.delete("/manager/:managerId", authenticateToken, deleteManager);

export default adminRouter;
