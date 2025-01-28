import { DataTypes, Model } from "sequelize";
import bcrypt from "bcrypt";
import dbST from "../utils/database.js";

class User extends Model {}

User.init(
  {
    id: {
      type: DataTypes.INTEGER,
      autoIncrement: true,
      primaryKey: true,
    },
    firstName: {
      type: DataTypes.STRING,
      allowNull: false, // Поле обязательно для заполнения
    },
    lastName: {
      type: DataTypes.STRING,
      allowNull: false, // Поле обязательно для заполнения
    },
    email: {
      type: DataTypes.STRING,
      allowNull: false,
      validate: {
        isEmail: true,
      },
    },
    password: {
      type: DataTypes.STRING,
      allowNull: false,
    },
    gender: {
      type: DataTypes.ENUM("male", "female"),
      allowNull: false, // Пол обязателен
    },
    role: {
      type: DataTypes.ENUM("client", "admin", "doctor", "manager"),
      defaultValue: "client",
    },
    avatar: {
      type: DataTypes.STRING,
      allowNull: true,
      defaultValue: "/backend/uploads/avatars/default_avatar.png",
    },
    lastLogin: {
      type: DataTypes.DATE,
      allowNull: true, // Поле необязательно, может быть null
    },
  },
  {
    sequelize: dbST,
    modelName: "User",
    tableName: "users",
    timestamps: true,
    indexes: [{ fields: ["email"], unique: true }],
  }
);
User.beforeCreate(async (user) => {
  if (user.password) {
    const salt = await bcrypt.genSalt(10);
    user.password = await bcrypt.hash(user.password, salt);
  }
});

User.prototype.comparePassword = async function (password) {
  return bcrypt.compare(password, this.password);
};

export default User;
