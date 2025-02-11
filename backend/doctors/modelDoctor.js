import { DataTypes, Model } from "sequelize";
import dbST from "../utils/database.js";
import User from "../users/modelUser.js"; // Импорт модели User

class Doctor extends Model {}

Doctor.init(
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
    email: {
      type: DataTypes.STRING,
      allowNull: false,
      validate: {
        isEmail: true,
      },
    },
    mobilePhone: {
      type: DataTypes.STRING(18), // 18 символов, чтобы влезал номер
      allowNull: false,
      validate: {
        is: /^\+7\s\(\d{3}\)\s\d{3}-\d{2}-\d{2}$/, // Правильный формат
      },
    },
    specialty: {
      type: DataTypes.STRING,
      allowNull: false,
    },
    userId: {
      type: DataTypes.INTEGER,
      allowNull: false,
      references: {
        model: User, // Ссылка на таблицу users
        key: "id", // Поле, на которое ссылаемся
      },
    },
    isDeleted: {
      type: DataTypes.BOOLEAN,
      defaultValue: false, // Врачи по умолчанию не удалены
    },
  },
  {
    sequelize: dbST,
    modelName: "Doctor",
    tableName: "doctors",
    timestamps: true,
    indexes: [{ fields: ["email"], unique: true }],
  }
);

// Устанавливаем связь
User.hasOne(Doctor, { foreignKey: "userId", as: "doctorProfile" });
Doctor.belongsTo(User, { foreignKey: "userId", as: "userAccount" });

export default Doctor;
