// controllers/userController.js
const bcrypt = require('bcryptjs');
const User = require('../models/User');

// GET Registration Page
exports.getRegister = (req, res) => {
  res.render('register', { title: 'Register' });
};

// POST Registration
exports.postRegister = async (req, res) => {
  try {
    const { username, password } = req.body;
    // Check if user already exists
    const userExists = await User.findOne({ username });
    if (userExists) {
      return res.status(400).send('User already exists!');
    }

    // Hash password
    const salt = await bcrypt.genSalt(10);
    const hash = await bcrypt.hash(password, salt);

    // Create new user
    const newUser = new User({ username, password: hash });
    await newUser.save();
    res.redirect('/users/login');
  } catch (error) {
    console.error(error);
    res.status(500).send('Server error while registering user');
  }
};

// GET Login Page
exports.getLogin = (req, res) => {
  res.render('login', { title: 'Login' });
};

// POST Login
exports.postLogin = async (req, res) => {
  try {
    const { username, password } = req.body;

    // Find user
    const user = await User.findOne({ username });
    if (!user) {
      return res.status(400).send('Invalid credentials');
    }

    // Compare password
    const isMatch = await bcrypt.compare(password, user.password);
    if (!isMatch) {
      return res.status(400).send('Invalid credentials');
    }

    // Save user in session
    req.session.user = user;
    return res.redirect('/books/catalogue');
  } catch (error) {
    console.error(error);
    res.status(500).send('Server error while logging in');
  }
};

// GET Logout
exports.logout = (req, res) => {
  req.session.destroy((err) => {
    if (err) console.error(err);
    res.redirect('/');
  });
};
