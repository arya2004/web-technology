// routes/auth.js
const express = require('express');
const bcrypt = require('bcryptjs');
const jwt = require('jsonwebtoken');
const { Consumer } = require('../models');
require('dotenv').config();

const router = express.Router();

// POST /api/auth/register
router.post('/register', async (req, res) => {
  try {
    const { name, email, password, role } = req.body;
    if (!name || !email || !password || !['user','admin'].includes(role))
      return res.status(400).json({ message: 'Name, email, password and valid role are required' });

    const existing = await Consumer.findOne({ where: { email } });
    if (existing)
      return res.status(400).json({ message: 'Email already in use' });

    const hash = await bcrypt.hash(password, 10);
    const user = await Consumer.create({ name, email, password: hash, role });
    res.status(201).json({ id: user.id, name: user.name, email: user.email, role: user.role });
  } catch (err) {
    console.error(err);
    res.status(500).json({ message: 'Server error' });
  }
});

// POST /api/auth/login
router.post('/login', async (req, res) => {
  try {
    const { email, password } = req.body;
    if (!email || !password)
      return res.status(400).json({ message: 'Email and password are required' });

    const user = await Consumer.findOne({ where: { email } });
    if (!user)
      return res.status(401).json({ message: 'Invalid credentials' });

    const valid = await bcrypt.compare(password, user.password);
    if (!valid)
      return res.status(401).json({ message: 'Invalid credentials' });

    const token = jwt.sign(
      { id: user.id, email: user.email, role: user.role },
      process.env.JWT_SECRET,
      { expiresIn: process.env.JWT_EXPIRES_IN }
    );

    res.json({ token, role: user.role });
  } catch (err) {
    console.error(err);
    res.status(500).json({ message: 'Server error' });
  }
});

module.exports = router;
