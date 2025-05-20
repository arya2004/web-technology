// middleware/auth.js
const jwt = require('jsonwebtoken');
require('dotenv').config();

const authenticate = (req, res, next) => {
  const authHeader = req.headers.authorization;
  if (!authHeader?.startsWith('Bearer '))
    return res.status(401).json({ message: 'Missing or invalid Authorization header' });

  const token = authHeader.split(' ')[1];
  try {
    const payload = jwt.verify(token, process.env.JWT_SECRET);
    req.user = { id: payload.id, email: payload.email, role: payload.role };
    next();
  } catch (err) {
    return res.status(401).json({ message: 'Invalid or expired token' });
  }
};

const authorizeAdmin = (req, res, next) => {
  if (req.user.role !== 'admin')
    return res.status(403).json({ message: 'Admin privileges required' });
  next();
};

module.exports = { authenticate, authorizeAdmin };
