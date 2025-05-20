const { DataTypes } = require('sequelize');
const sequelize = require('../config/database');

const Item = sequelize.define('Item', {
  id: {
    type: DataTypes.INTEGER.UNSIGNED,
    primaryKey: true,
    autoIncrement: true
  },
  name: {
    type: DataTypes.STRING(150),
    allowNull: false
  },
  description: {
    type: DataTypes.TEXT,
    allowNull: true
  },
  price: {
    type: DataTypes.DECIMAL(10,2),
    allowNull: false
  },
  imageUrl: {
    type: DataTypes.STRING,
    allowNull: true
  }
}, {
  tableName: 'items',
  timestamps: true
});

module.exports = Item;
