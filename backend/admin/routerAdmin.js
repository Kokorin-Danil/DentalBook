import { Router } from "express";
import {
  createAdminUser,
  getAllDoctors,
  getAllPatients,
} from "./controllerAdmin.js";
import { authenticateToken } from "../utils/authMiddleware.js";

const adminRouter = Router();

adminRouter.post("/create/admin", createAdminUser);
adminRouter.get("/doctors/get", authenticateToken, getAllDoctors);
adminRouter.get("/patients/get", authenticateToken, getAllPatients);

export default adminRouter;
