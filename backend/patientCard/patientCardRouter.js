import express from "express";
import {
  createPatientCard,
  createVisit,
  changeVisitStatus,
  getClientVisits,
  getDoctorsSchedule,
  getPatientCards,
  getPatientProfile,
  createPatientNote,
  getPatientNotes,
  getWeeklySchedule,
  getMonthlySchedule,
  createSnapshot,
  getSnapshotsByPatientCard,
  updateTeethStatuses,
  getTeethWithStatuses,
  addExaminationSheet,
  getExaminationSheets,
  getPatientCardDetails,
  deletePatientCard,
} from "./patientCardController.js";
import { uploadSnapshot } from "../utils/middleware.js";
import { authenticateToken } from "../utils/authMiddleware.js";

const PatientCardRouter = express.Router();

// Создание карты пациента
PatientCardRouter.post("/create", createPatientCard);
PatientCardRouter.post("/visit/create", createVisit);
PatientCardRouter.post("/visit/change/:visitId", changeVisitStatus);
PatientCardRouter.get("/visit/all/:PatientCardId", getClientVisits);
PatientCardRouter.get("/schedule/:date", getDoctorsSchedule);
PatientCardRouter.get("/get/all", getPatientCards);
PatientCardRouter.get("/get/patient_profile/:patientCardId", getPatientProfile);
PatientCardRouter.post("/notes/create/:patientCardId", createPatientNote);
PatientCardRouter.get("/notes/getall/:patientCardId", getPatientNotes);
PatientCardRouter.get(
  "/schedule/weekly/:startDate/:endDate",
  getWeeklySchedule
);
PatientCardRouter.get("/schedule/monthly/:month", getMonthlySchedule);
PatientCardRouter.post(
  "/snapshots/create",
  authenticateToken,
  uploadSnapshot.single("snapshots"),
  createSnapshot
);
PatientCardRouter.get(
  "/snapshots/getall/:patientCardId",
  getSnapshotsByPatientCard
);
PatientCardRouter.put("/teeth/update/:patientCardId", updateTeethStatuses);
PatientCardRouter.get("/teeth/get/:patientCardId", getTeethWithStatuses);
PatientCardRouter.post(
  "/examinationsheet/create/:patientCardId",
  addExaminationSheet
);
PatientCardRouter.get(
  "/examinationsheet/get/:patientCardId",
  getExaminationSheets
);
PatientCardRouter.get("/document/get/:patientCardId", getPatientCardDetails);
PatientCardRouter.delete("/card/:patientCardId", deletePatientCard);

export default PatientCardRouter;
