import express from "express";
import {
  createPatientCard,
  createVisit,
  changeVisitStatus,
  getClientVisits,
  getDoctorsSchedule,
  getWeeklyVisits,
  getPatientCards,
} from "./patientCardController.js";

const PatientCardRouter = express.Router();

// Создание карты пациента
PatientCardRouter.post("/create", createPatientCard);
PatientCardRouter.post("/visit/create", createVisit);
PatientCardRouter.post("/visit/change", changeVisitStatus);
PatientCardRouter.get("/visit/all/:clientId", getClientVisits);
PatientCardRouter.get("/schedule/:date", getDoctorsSchedule);
PatientCardRouter.get("/visits/weekly/:date", getWeeklyVisits);
PatientCardRouter.get("/get/all", getPatientCards);

export default PatientCardRouter;
