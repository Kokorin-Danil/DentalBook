import { Router } from "express";
import {
  login,
  getClientProfile,
  getPatientCardIdByFullName,
  updateUser,
  uploadUserAvatar,
  getPatientCardNumber,
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
authRouter.post("/avatar/upload", authenticateToken, uploadUserAvatar);
authRouter.get("/getId/patientCard", authenticateToken, getPatientCardNumber);

export default authRouter;
