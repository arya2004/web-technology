// routes/userRoutes.js
const express = require('express');
const router = express.Router();
const userController = require('../controllers/userController');

// Register
router.get('/register', userController.getRegister);
router.post('/register', userController.postRegister);

// Login
router.get('/login', userController.getLogin);
router.post('/login', userController.postLogin);

// Logout
router.get('/logout', userController.logout);

module.exports = router;
