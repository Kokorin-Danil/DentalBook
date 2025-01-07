import jwt from "jsonwebtoken";
import User from "../users/modelUser.js";

export const authenticateToken = async (req, res, next) => {
  const authHeader = req.headers["authorization"];
  const token = authHeader && authHeader.split(" ")[1];

  if (!token) {
    return res.status(401).json({ message: "Токен отсутствует" });
  }

  try {
    const decoded = jwt.verify(token, process.env.JWT_SECRET); // Расшифровка токена
    const user = await User.findByPk(decoded.id); // Поиск пользователя по ID из токена

    if (!user) {
      return res.status(404).json({ message: "Пользователь не найден" });
    }

    req.user = { id: user.id, role: user.role }; // Добавляем ID и роль пользователя в запрос
    next();
  } catch (error) {
    console.error("Ошибка проверки токена:", error);
    return res.status(403).json({ message: "Недействительный токен" });
  }
};
