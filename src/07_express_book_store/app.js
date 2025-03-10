// app.js
const express = require('express');
const mongoose = require('mongoose');
const session = require('express-session');
const path = require('path');
const dbConfig = require('./config/db');
const indexRoutes = require('./routes/index');
const userRoutes = require('./routes/userRoutes');
const bookRoutes = require('./routes/bookRoutes');
const { initBooksIfEmpty } = require('./controllers/bookController');

const app = express();

// Connect to MongoDB
mongoose
  .connect(dbConfig.mongoURI, {
    useNewUrlParser: true,
    useUnifiedTopology: true,
  })
  .then(async () => {
    console.log('MongoDB connected');
    // Seed books if empty
    await initBooksIfEmpty();
  })
  .catch((err) => console.log(err));

// Sessions (to identify logged-in users)
app.use(
  session({
    secret: 'YourSecretKey',
    resave: false,
    saveUninitialized: false,
  })
);

app.use((req, res, next) => {
    res.locals.user = req.session.user || null;
    next();
  });

// EJS setup
app.set('view engine', 'ejs');

// Body parser
app.use(express.urlencoded({ extended: true }));
app.use(express.json());

// Make "public" folder accessible for static files
app.use(express.static(path.join(__dirname, 'public')));

// Routes
app.use('/', indexRoutes);
app.use('/users', userRoutes);
app.use('/books', bookRoutes);

const PORT = process.env.PORT || 3000;
app.listen(PORT, () => {
  console.log(`Server running on port ${PORT}`);
});
