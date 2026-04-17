import "dotenv/config";
import path from "node:path";
import express from "express";
import cors from "cors";
import { fileURLToPath } from "node:url";
import { router as contactRouter } from "./src/contactRoutes.mjs";

const app = express();
const port = Number(process.env.PORT || 3000);

app.use(cors({ origin: "*" }));

// For x-www-form-urlencoded (from your HTML)
app.use(express.urlencoded({ extended: false }));
app.use(express.json());

app.use("/api", contactRouter);

// Optional: serve this folder so you can open http://localhost:3000/index.html
const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);
app.use(express.static(__dirname));

app.get("/health", (_req, res) => {
  res.json({ ok: true });
});

app.listen(port, () => {
  // eslint-disable-next-line no-console
  console.log(`Server running on http://localhost:${port}`);
});
