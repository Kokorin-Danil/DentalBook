import { DataTypes, Model } from "sequelize";
import dbST from "../utils/database.js";
import { PatientCard } from "./modelPatientCard.js";

class MedicalSurvey extends Model {}

MedicalSurvey.init(
  {
    id: {
      type: DataTypes.INTEGER,
      autoIncrement: true,
      primaryKey: true,
    },
    patientCardId: {
      type: DataTypes.INTEGER,
      allowNull: false,
      references: {
        model: "patient_cards",
        key: "id",
      },
    },
    toothPain: {
      type: DataTypes.ENUM("Да", "Нет", "Не знаю"),
      allowNull: false,
    },
    toothSensitivity: {
      type: DataTypes.ENUM("Да", "Нет", "Не знаю"),
      allowNull: false,
    },
    gumBleeding: {
      type: DataTypes.ENUM("Да", "Нет", "Не знаю"),
      allowNull: false,
    },
    dentalWork: {
      type: DataTypes.ENUM("Да", "Нет", "Не знаю"),
      allowNull: false,
    },
    dentalDevices: {
      type: DataTypes.ENUM("Да", "Нет", "Не знаю"),
      allowNull: false,
    },
    gumInflammation: {
      type: DataTypes.ENUM("Да", "Нет", "Не знаю"),
      allowNull: false,
    },
    gumChanges: {
      type: DataTypes.ENUM("Да", "Нет", "Не знаю"),
      allowNull: false,
    },
    exposedRoots: {
      type: DataTypes.ENUM("Да", "Нет", "Не знаю"),
      allowNull: false,
    },
    jawPain: { type: DataTypes.ENUM("Да", "Нет", "Не знаю"), allowNull: false },
    teethGrinding: {
      type: DataTypes.ENUM("Да", "Нет", "Не знаю"),
      allowNull: false,
    },
    brushesTeethTwice: {
      type: DataTypes.ENUM("Да", "Нет", "Не знаю"),
      allowNull: false,
    },
    flossOrIrrigator: {
      type: DataTypes.ENUM("Да", "Нет", "Не знаю"),
      allowNull: false,
    },
    smoking: { type: DataTypes.ENUM("Да", "Нет", "Не знаю"), allowNull: false },
    dentalAllergy: {
      type: DataTypes.ENUM("Да", "Нет", "Не знаю"),
      allowNull: false,
    },
    anesthesiaReaction: {
      type: DataTypes.ENUM("Да", "Нет", "Не знаю"),
      allowNull: false,
    },
  },
  {
    sequelize: dbST,
    modelName: "MedicalSurvey",
    tableName: "medical_surveys",
    timestamps: true,
  }
);

export default MedicalSurvey;
