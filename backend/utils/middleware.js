import multer from "multer";
import path from "path";

// Конфигурация хранилища для аватарок
const avatarStorage = multer.diskStorage({
  destination: (req, file, cb) => {
    cb(null, "/backend/uploads/avatars/"); // Папка для загрузки аватарок
  },
  filename: (req, file, cb) => {
    const uniqueSuffix = Date.now() + "-" + Math.round(Math.random() * 1e9);
    cb(null, uniqueSuffix + path.extname(file.originalname)); // Уникальное имя файла
  },
});

// Конфигурация хранилища для снимков
const snapshotStorage = multer.diskStorage({
  destination: (req, file, cb) => {
    cb(null, "/backend/uploads/snapshots/"); // Папка для загрузки снимков
  },
  filename: (req, file, cb) => {
    const uniqueSuffix = Date.now() + "-" + Math.round(Math.random() * 1e9);
    cb(null, uniqueSuffix + path.extname(file.originalname)); // Уникальное имя файла
  },
});

// Общий конфиг для валидации файлов
const fileFilter = (req, file, cb) => {
  const filetypes = /jpeg|jpg|png/;
  const extname = filetypes.test(path.extname(file.originalname).toLowerCase());
  const mimetype = filetypes.test(file.mimetype);

  if (mimetype && extname) {
    return cb(null, true);
  } else {
    cb(new Error("Разрешены только изображения форматов JPEG, JPG, PNG"));
  }
};

// Загрузчики
const uploadAvatar = multer({
  storage: avatarStorage,
  limits: { fileSize: 2 * 1024 * 1024 }, // Ограничение на размер файла (2 МБ)
  fileFilter,
});

const uploadSnapshot = multer({
  storage: snapshotStorage,
  limits: { fileSize: 5 * 1024 * 1024 }, // Ограничение на размер файла (5 МБ)
  fileFilter,
});

export { uploadAvatar, uploadSnapshot };
