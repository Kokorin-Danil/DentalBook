import { DataTypes, Model } from "sequelize";
import dbST from "../utils/database.js";
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
      type: DataTypes.ENUM("Лечение", "Осмотр", "Консультация"),
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
      type: DataTypes.ENUM("Не подтвержден", "Подтвержден", "Отменен"),
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

class Snapshot extends Model {}

Snapshot.init(
  {
    id: {
      type: DataTypes.INTEGER,
      autoIncrement: true,
      primaryKey: true,
    },
    createdAt: {
      type: DataTypes.DATE,
      allowNull: false,
      defaultValue: DataTypes.NOW,
    },
    visitId: {
      type: DataTypes.INTEGER,
      allowNull: false,
      references: {
        model: Visit, // Ссылка на модель визитов
        key: "id",
      },
    },
    patientCardId: {
      type: DataTypes.INTEGER,
      allowNull: false,
      references: {
        model: PatientCard, // Ссылка на модель карты пациента
        key: "id",
      },
    },
    snapshotFile: {
      type: DataTypes.STRING,
      allowNull: false,
    },
    toothNumbers: {
      type: DataTypes.STRING,
      allowNull: true,
    },
    note: {
      type: DataTypes.TEXT,
      allowNull: true,
    },
  },
  {
    sequelize: dbST,
    modelName: "Snapshot",
    tableName: "snapshots",
    timestamps: false, // Поле createdAt управляется вручную
  }
);

class Tooth extends Model {}

Tooth.init(
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
        model: "patient_cards", // Название таблицы карт пациентов
        key: "id",
      },
    },
    toothNumber: {
      type: DataTypes.ENUM(
        "11",
        "12",
        "13",
        "14",
        "15",
        "16",
        "17",
        "18",
        "21",
        "22",
        "23",
        "24",
        "25",
        "26",
        "27",
        "28",
        "31",
        "32",
        "33",
        "34",
        "35",
        "36",
        "37",
        "38",
        "41",
        "42",
        "43",
        "44",
        "45",
        "46",
        "47",
        "48"
      ),
      allowNull: false,
    },
  },
  {
    sequelize: dbST,
    modelName: "Tooth",
    tableName: "teeth",
    timestamps: true,
  }
);

class ToothStatus extends Model {}

ToothStatus.init(
  {
    id: {
      type: DataTypes.INTEGER,
      autoIncrement: true,
      primaryKey: true,
    },
    toothId: {
      type: DataTypes.INTEGER,
      allowNull: false,
      references: {
        model: "Teeth", // Название таблицы зубов
        key: "id",
      },
    },
    status: {
      type: DataTypes.ENUM(
        "Лечение",
        "Удаление",
        "Коронка",
        "Кариес",
        "Пломба",
        "Протез",
        "Киста"
      ),
      allowNull: false,
    },
  },
  {
    sequelize: dbST,
    modelName: "ToothStatus",
    tableName: "tooth_statuses",
    timestamps: true,
  }
);

class ExaminationSheet extends Model {}

ExaminationSheet.init(
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
        model: "patient_cards", // Название таблицы карт пациентов
        key: "id",
      },
    },
    type: {
      type: DataTypes.ENUM(
        "Первичный осмотр",
        "Повторный визит",
        "Профилактическая чистка",
        "Экстренный случай"
      ),
      allowNull: false,
    },
    complaints: {
      // Жалобы пациента для первичного осмотра
      type: DataTypes.TEXT,
      allowNull: true,
    },
    preliminaryDiagnosis: {
      // Предварительный диагноз (для первичного осмотра)
      type: DataTypes.ENUM(
        "Кариес",
        "Пародонтит",
        "Гингивит",
        "Абсцесс",
        "Гиперчувствительность зубов",
        "Дисфункция ВНЧС",
        "Кандидоз",
        "Лейкоплакия",
        "Ретинированные зубы мудрости",
        "Гипоплазия эмали"
      ),
      allowNull: true,
    },
    doctorRecommendations: {
      // Рекомендации врача (для первичного осмотра и экстренных случаев)
      type: DataTypes.TEXT,
      allowNull: true,
    },
    conditionDynamics: {
      // Динамика состояния (для повторного визита)
      type: DataTypes.TEXT,
      allowNull: true,
    },
    treatmentResults: {
      // Результаты лечения (для повторного визита)
      type: DataTypes.TEXT,
      allowNull: true,
    },
    cleaningGoal: {
      // Цель чистки (для профилактической чистки)
      type: DataTypes.TEXT,
      allowNull: true,
    },
    cleaningProcedure: {
      // Процедура чистки (для профилактической чистки)
      type: DataTypes.ENUM(
        "Скалинг",
        "Полировка зубов",
        "Фторирование зубов",
        "Лазерная чистка",
        "Пескоструйная обработка",
        "Ручная чистка",
        "Ультразвуковая чистка",
        "Глубокая чистка",
        "Антибактериальная обработка",
        "Локальная реминерализация",
        "Отбеливающая чистка",
        "Чистка дентальных имплантатов",
        "Чистка ортодонтических конструкций"
      ),
      allowNull: true,
    },
    additionalCleaningProcedures: {
      // Дополнительные процедуры (для профилактической чистки)
      type: DataTypes.TEXT,
      allowNull: true,
    },
    postCleaningCondition: {
      // Состояние после чистки (для профилактической чистки)
      type: DataTypes.TEXT,
      allowNull: true,
    },
    problemDescription: {
      // Описание проблемы (для экстренного случая)
      type: DataTypes.TEXT,
      allowNull: true,
    },
    conditionAssessment: {
      // Оценка состояния (для экстренного случая)
      type: DataTypes.ENUM(
        "Сильная зубная боль",
        "Опухоль/воспаление",
        "Кровотечение",
        "Травма зуба/челюсти",
        "Онемение в области лица или челюсти",
        "Резкий запах изо рта"
      ),
      allowNull: true,
    },
    additionalDetails: {
      // Дополнительные детали (для экстренного случая)
      type: DataTypes.TEXT,
      allowNull: true,
    },
    measuresTaken: {
      // Принятые меры (для экстренного случая)
      type: DataTypes.TEXT,
      allowNull: true,
    },
  },
  {
    sequelize: dbST,
    modelName: "ExaminationSheet",
    tableName: "examination_sheets",
    timestamps: true,
  }
);

PatientCard.hasMany(ExaminationSheet, {
  foreignKey: "patientCardId",
  as: "examinations",
});
ExaminationSheet.belongsTo(PatientCard, {
  foreignKey: "patientCardId",
  as: "SheetpatientCard",
});

// Ассоциации
Visit.hasMany(Snapshot, { foreignKey: "visitId", as: "snapshots" });
Snapshot.belongsTo(Visit, { foreignKey: "visitId", as: "visit" });

PatientCard.hasMany(Snapshot, { foreignKey: "patientCardId", as: "snapshots" });
Snapshot.belongsTo(PatientCard, {
  foreignKey: "patientCardId",
  as: "patientCard",
});

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

PatientCard.afterCreate(async (patientCard, options) => {
  const toothNumbers = [
    "11",
    "12",
    "13",
    "14",
    "15",
    "16",
    "17",
    "18",
    "21",
    "22",
    "23",
    "24",
    "25",
    "26",
    "27",
    "28",
    "31",
    "32",
    "33",
    "34",
    "35",
    "36",
    "37",
    "38",
    "41",
    "42",
    "43",
    "44",
    "45",
    "46",
    "47",
    "48",
  ];

  const teeth = toothNumbers.map((toothNumber) => ({
    patientCardId: patientCard.id,
    toothNumber,
    statuses: [],
  }));

  await Tooth.bulkCreate(teeth, { transaction: options.transaction });
});

PatientCard.hasMany(Tooth, { foreignKey: "patientCardId", as: "teeth" });
Tooth.belongsTo(PatientCard, {
  foreignKey: "patientCardId",
  as: "patientCardtooth",
});
Tooth.hasMany(ToothStatus, { foreignKey: "toothId", as: "statuses" });
ToothStatus.belongsTo(Tooth, { foreignKey: "toothId", as: "tooth" });

export {
  PatientCard,
  Visit,
  PatientNote,
  Snapshot,
  Tooth,
  ToothStatus,
  ExaminationSheet,
};
