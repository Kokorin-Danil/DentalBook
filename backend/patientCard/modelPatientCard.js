import { DataTypes, Model } from "sequelize";
import dbST from "../database.js";
import Doctor from "../doctors/modelDoctor.js"; // Импорт модели врача
import User from "../users/modelUser.js";

// Модель карты пациента
class PatientCard extends Model {}

PatientCard.init(
  {
    id: {
      type: DataTypes.INTEGER,
      autoIncrement: true,
      primaryKey: true,
    },
    firstName: {
      type: DataTypes.STRING,
      allowNull: false,
    },
    lastName: {
      type: DataTypes.STRING,
      allowNull: false,
    },
    patronymic: {
      type: DataTypes.STRING,
      allowNull: true,
    },
    dateOfBirth: {
      type: DataTypes.DATEONLY,
      allowNull: false,
    },
    address: {
      type: DataTypes.STRING,
      allowNull: false,
    },
    phoneNumber: {
      type: DataTypes.STRING,
      allowNull: false,
      validate: {
        is: /^[0-9+\-() ]+$/i, // Проверка на формат номера телефона
      },
    },
    email: {
      type: DataTypes.STRING,
      allowNull: false,
      validate: {
        isEmail: true,
      },
    },
    gender: {
      type: DataTypes.ENUM("male", "female"),
      allowNull: false, // Пол обязателен
    },
    clientId: {
      type: DataTypes.INTEGER,
      allowNull: false,
    },
    policyNumber: {
      type: DataTypes.STRING,
      allowNull: false, // Поле обязательно
      validate: {
        is: /^\d{4}\s\d{4}\s\d{4}\s\d{4}$/, // Проверка формата: 1234 5678 9101 1121
      },
    },
    snils: {
      type: DataTypes.STRING,
      allowNull: false, // СНИЛС обязателен
      validate: {
        is: /^\d{3}-\d{3}-\d{3}\s\d{2}$/, // Формат: 123-456-789 00
      },
    },
    passport: {
      type: DataTypes.STRING,
      allowNull: false, // Паспорт обязателен
      validate: {
        is: /^\d{4}\s\d{6}$/, // Формат: 1234 567890
      },
    },
  },
  {
    sequelize: dbST,
    modelName: "PatientCard",
    tableName: "patient_cards",
    timestamps: true,
    indexes: [{ fields: ["policyNumber"], unique: true }],
  }
);

// Модель визита
class Visit extends Model {}

Visit.init(
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
        model: PatientCard, // Ссылка на модель карты пациента
        key: "id",
      },
    },
    visitType: {
      type: DataTypes.ENUM("лечение", "осмотр", "консультация"),
      allowNull: false,
    },
    doctorId: {
      type: DataTypes.INTEGER,
      allowNull: false,
      references: {
        model: Doctor, // Ссылка на модель врача
        key: "id",
      },
    },
    visitDate: {
      type: DataTypes.DATEONLY,
      allowNull: false,
    },
    visitTime: {
      type: DataTypes.TIME,
      allowNull: false,
    },
    visitStatus: {
      type: DataTypes.ENUM("не подтвержден", "подтвержден", "отменен"),
      allowNull: false,
      defaultValue: "не подтвержден", // Статус по умолчанию
    },
  },
  {
    sequelize: dbST,
    modelName: "Visit",
    tableName: "visits",
    timestamps: true,
  }
);

class PatientNote extends Model {}

PatientNote.init(
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
        model: PatientCard, // Ссылка на модель карты пациента
        key: "id",
      },
    },
    doctorId: {
      type: DataTypes.INTEGER,
      allowNull: false,
      references: {
        model: Doctor, // Ссылка на модель доктора
        key: "id",
      },
    },
    name: {
      type: DataTypes.STRING,
      allowNull: false,
    },
    description: {
      type: DataTypes.TEXT,
      allowNull: false,
    },
    importance: {
      type: DataTypes.ENUM("Высокая", "Средняя", "Низкая"),
      allowNull: false,
      defaultValue: "Средняя",
    },
  },
  {
    sequelize: dbST,
    modelName: "PatientNote",
    tableName: "patient_notes",
    timestamps: true, // Автоматические поля createdAt и updatedAt
  }
);

// Ассоциации для PatientNote
PatientCard.hasMany(PatientNote, {
  as: "patientNotes",
  foreignKey: "patientCardId",
});
PatientNote.belongsTo(PatientCard, {
  foreignKey: "patientCardId",
  as: "patientCard",
});

Doctor.hasMany(PatientNote, { as: "doctorNotes", foreignKey: "doctorId" });
PatientNote.belongsTo(Doctor, { foreignKey: "doctorId", as: "doctor" });

// Ассоциации для Visit
PatientCard.hasMany(Visit, { foreignKey: "patientCardId", as: "visits" });
Visit.belongsTo(PatientCard, {
  foreignKey: "patientCardId",
  as: "patientCard",
});

Doctor.hasMany(Visit, { foreignKey: "doctorId", as: "visits" });
Visit.belongsTo(Doctor, { foreignKey: "doctorId", as: "doctor" });

// Ассоциация между User и PatientCard
User.hasOne(PatientCard, { foreignKey: "clientId", as: "patientCard" });
PatientCard.belongsTo(User, { foreignKey: "clientId", as: "user" });

export { PatientCard, Visit, PatientNote };
