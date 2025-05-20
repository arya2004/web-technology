// server.js
require('dotenv').config();
const express = require('express');
const cors = require('cors');
const { initDB } = require('./models');
const authRoutes = require('./routes/auth');
const itemRoutes = require('./routes/items');

const app = express();
const PORT = process.env.PORT || 5000;

// CORS: allow frontend origin
app.use(cors({
  origin: 'http://localhost:3000',
  credentials: true
}));

app.use(express.json());

// Initialize DB and then start server
initDB()
  .then(() => {
    // Routes
    app.use('/api/auth', authRoutes);
    app.use('/api/items', itemRoutes);

    app.listen(PORT, () => {
      console.log(`🚀 Server running on http://localhost:${PORT}`);
    });
  })
  .catch(err => {
    console.error('❌ Failed to initialize database:', err);
  });
