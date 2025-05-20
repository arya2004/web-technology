// routes/items.js
const express = require('express');
const { authenticate, authorizeAdmin } = require('../middleware/auth');
const { Item } = require('../models');

const router = express.Router();

// GET /api/items/           ← all authenticated users
router.get('/', authenticate, async (req, res) => {
  try {
    const items = await Item.findAll({ order: [['id','ASC']] });
    res.json(items);
  } catch (err) {
    console.error(err);
    res.status(500).json({ message: 'Server error' });
  }
});

// POST /api/items/          ← admin only
router.post('/', authenticate, authorizeAdmin, async (req, res) => {
  try {
    const { name, description, price, imageUrl } = req.body;
    const item = await Item.create({ name, description, price, imageUrl });
    res.status(201).json(item);
  } catch (err) {
    console.error(err);
    res.status(500).json({ message: 'Server error' });
  }
});

// PUT /api/items/:id        ← admin only
router.put('/:id', authenticate, authorizeAdmin, async (req, res) => {
  try {
    const { name, description, price, imageUrl } = req.body;
    const [updated] = await Item.update(
      { name, description, price, imageUrl },
      { where: { id: req.params.id } }
    );
    if (!updated) return res.status(404).json({ message: 'Item not found' });
    const item = await Item.findByPk(req.params.id);
    res.json(item);
  } catch (err) {
    console.error(err);
    res.status(500).json({ message: 'Server error' });
  }
});

// DELETE /api/items/:id     ← admin only
router.delete('/:id', authenticate, authorizeAdmin, async (req, res) => {
  try {
    const deleted = await Item.destroy({ where: { id: req.params.id } });
    if (!deleted) return res.status(404).json({ message: 'Item not found' });
    res.status(204).end();
  } catch (err) {
    console.error(err);
    res.status(500).json({ message: 'Server error' });
  }
});

module.exports = router;
