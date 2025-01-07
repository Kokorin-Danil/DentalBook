import dotenv from "dotenv";
dotenv.config();

export const config = {
  HOST: process.env.HOST,
  PORT: process.env.PORT,
  TABLE: process.env.TABLE,
};
