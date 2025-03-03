const express = require("express");
const mongoose = require("mongoose");
const bodyParser = require("body-parser");
const { v4: uuidv4 } = require("uuid");

const app = express();
app.use(bodyParser.json());


mongoose.connect("mongodb://0.0.0.0:27017/vit_results", {
    useNewUrlParser: true,
    useUnifiedTopology: true,
});

const db = mongoose.connection;

db.on("connected", () => console.log("✅ MongoDB Connected Successfully!"));
db.on("error", (err) => console.error("❌ MongoDB Connection Error:", err));
db.on("disconnected", () => console.log("⚠️ MongoDB Disconnected!"));

// Schema
const studentSchema = new mongoose.Schema({
    studentId: { type: String, default: uuidv4, unique: true },
    name: String,
    rollNumber: { type: String, unique: true },
    marks: {
        DAA: { mse: Number, ese: Number },
        SDAM: { mse: Number, ese: Number },
        WT: { mse: Number, ese: Number },
        EDI: { mse: Number, ese: Number },
    },
});

const Student = mongoose.model("Student", studentSchema);


app.post("/add-student", async (req, res) => {
    try {
        const { name, rollNumber } = req.body;
        const newStudent = new Student({ name, rollNumber, marks: {} });
        await newStudent.save();
        res.status(201).send({ message: "Student added successfully!", student: newStudent });
    } catch (err) {
        res.status(500).send({ error: err.message });
    }
});


app.post("/add-marks/:rollNumber", async (req, res) => {
    try {
        const { rollNumber } = req.params;
        const { SDAM, EDI, WT, DAA } = req.body;

        const student = await Student.findOne({ rollNumber });
        if (!student) return res.status(404).send({ message: "Student not found!" });

        student.marks = { SDAM, EDI, WT, DAA };
        await student.save();
        res.status(200).send({ message: "Marks added successfully!", student });
    } catch (err) {
        res.status(500).send({ error: err.message });
    }
});


app.get("/result/:rollNumber", async (req, res) => {
    try {
        const { rollNumber } = req.params;
        const student = await Student.findOne({ rollNumber });
        if (!student) return res.status(404).send({ message: "Student not found!" });

        const calculateFinalMarks = (mse, ese) => (mse * 0.3) + (ese * 0.7);

        let finalResult = {};
        for (const [subject, marks] of Object.entries(student.marks)) {
            finalResult[subject] = calculateFinalMarks(marks.mse, marks.ese);
        }

        res.status(200).send({
            student: student.name,
            rollNumber: student.rollNumber,
            finalMarks: finalResult,
        });
    } catch (err) {
        res.status(500).send({ error: err.message });
    }
});

// Start Server
app.listen(3000, () => console.log("📡 Server running on port 3000"));
