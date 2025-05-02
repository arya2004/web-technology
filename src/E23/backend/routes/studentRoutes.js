const express = require('express');
const router = express.Router();
const db = require('../db');

// Store student data and marks
router.post('/', (req, res) => {
  const { name, reg_no, subjects } = req.body;

  db.query('INSERT INTO students (name, reg_no) VALUES (?, ?)', [name, reg_no], (err, result) => {
    if (err) return res.status(500).send(err);

    const studentId = result.insertId;

    subjects.forEach(({ subject, mse, ese }) => {
      db.query('INSERT INTO subjects (name) VALUES (?) ON DUPLICATE KEY UPDATE name=name', [subject]);

      db.query('SELECT id FROM subjects WHERE name = ?', [subject], (err, subRes) => {
        const subjectId = subRes[0].id;
        db.query('INSERT INTO marks (student_id, subject_id, mse, ese) VALUES (?, ?, ?, ?)', [studentId, subjectId, mse, ese]);
      });
    });

    res.send({ message: 'Student result saved successfully' });
  });
});

// Fetch results
router.get('/:reg_no', (req, res) => {
  const regNo = req.params.reg_no;
  db.query('SELECT * FROM students WHERE reg_no = ?', [regNo], (err, studentRes) => {
    if (err || studentRes.length === 0) return res.status(404).send({ error: 'Student not found' });

    const student = studentRes[0];
    db.query(
      `SELECT s.name AS subject, m.mse, m.ese, 
              (m.mse * 0.3 + m.ese * 0.7) AS total 
       FROM marks m 
       JOIN subjects s ON s.id = m.subject_id 
       WHERE m.student_id = ?`,
      [student.id],
      (err, marksRes) => {
        if (err) return res.status(500).send(err);

        const overall = marksRes.reduce((sum, subj) => sum + subj.total, 0) / marksRes.length;
        res.send({ student, subjects: marksRes, overall });
      }
    );
  });
});

module.exports = router;
