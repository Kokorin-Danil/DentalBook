import { Router } from "express";
import { login, getClientProfile, getPatientCardIdByFullName } from "./controllerUser.js";

const authRouter = Router();

// Роут для авторизации
authRouter.post("/login", login);
authRouter.get("/profile", getClientProfile);
authRouter.post("/patientCard",getPatientCardIdByFullName);

export default authRouter;
