// routes/index.js
const express = require('express');
const router = express.Router();

// Home page
router.get('/', (req, res) => {
  const user = req.session.user;
  res.render('home', { title: 'Online Bookstore', user });
});

module.exports = router;
