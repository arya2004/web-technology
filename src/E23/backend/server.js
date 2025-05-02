const express = require('express')
const bodyParser = require('body-parser')
const cors = require('cors');
const studentRoutes = require('./routes/studentRoutes');

const app = express();
app.use(cors());
app.use(bodyParser.json())

app.use('/api/students', studentRoutes);

app.listen(5000, () => console.log('runnging on 5000'))