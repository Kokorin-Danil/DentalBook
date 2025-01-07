import express from "express";
import {
  createPatientCard,
  createVisit,
  changeVisitStatus,
  getClientVisits,
  getDoctorsSchedule,
  getWeeklyVisits,
  getPatientCards,
  getPatientProfile,
  createPatientNote,
  getPatientNotes,
} from "./patientCardController.js";

const PatientCardRouter = express.Router();

// Создание карты пациента
PatientCardRouter.post("/create", createPatientCard);
PatientCardRouter.post("/visit/create", createVisit);
PatientCardRouter.post("/visit/change", changeVisitStatus);
PatientCardRouter.get("/visit/all/:PatientCardId", getClientVisits);
PatientCardRouter.get("/schedule/:date", getDoctorsSchedule);
PatientCardRouter.get("/visits/weekly/:date", getWeeklyVisits);
PatientCardRouter.get("/get/all", getPatientCards);
PatientCardRouter.get("/get/patient_profile/:patientCardId", getPatientProfile);
PatientCardRouter.post("/notes/create", createPatientNote);
PatientCardRouter.get("/notes/getall/:patientCardId", getPatientNotes);

export default PatientCardRouter;
