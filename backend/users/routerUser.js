import { Router } from "express";
import {
  login,
  getClientProfile,
  getPatientCardIdByFullName,
  updateUser,
} from "./controllerUser.js";
import { authenticateToken } from "../utils/authMiddleware.js";
import { uploadAvatar } from "../utils/middleware.js";

const authRouter = Router();

// Роут для авторизации
authRouter.post("/login", login);
authRouter.get("/profile", getClientProfile);
authRouter.post("/patientCard", getPatientCardIdByFullName);
authRouter.put(
  "/profile/update",
  authenticateToken,
  uploadAvatar.single("avatar"),
  updateUser
);

export default authRouter;
