// routes/bookRoutes.js
const express = require('express');
const router = express.Router();
const bookController = require('../controllers/bookController');

// Anyone can view
router.get('/catalogue', bookController.showCatalogue);

// Add new book (logged-in only)
router.get('/add', bookController.getAddBook);
router.post('/add', bookController.postAddBook);

// Edit book (logged-in only)
router.get('/edit/:id', bookController.getEditBook);
router.post('/edit/:id', bookController.postEditBook);

// Delete book (logged-in only)
router.get('/delete/:id', bookController.deleteBook);

module.exports = router;
