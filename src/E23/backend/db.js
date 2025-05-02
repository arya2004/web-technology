const mysql = require('mysql2')

const connection = mysql.createConnection({
    host: 'localhost',
    user: 'root',
    password: 'root',
    database: 'vit_results'
})

connection.connect(err => {
    if (err) throw err
    console.log('connected to db')
})

module.exports = connection;