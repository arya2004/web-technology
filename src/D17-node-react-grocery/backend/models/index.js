const sequelize = require('../config/database');
const Consumer = require('./consumer');
const Item = require('./item');

// If you need associations, define here
// e.g., Consumer.hasMany(Order); etc.

const initDB = async () => {
  await sequelize.authenticate();
  await sequelize.sync({ alter: true });
  console.log('✅ Database synced');
};

module.exports = { sequelize, Consumer, Item, initDB };
