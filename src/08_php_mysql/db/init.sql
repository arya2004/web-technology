CREATE DATABASE IF NOT EXISTS test_db;
USE test_db;

CREATE TABLE IF NOT EXISTS test_table (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    age INT NOT NULL,
    address VARCHAR(150) NOT NULL
);

INSERT INTO test_table (first_name, age, address) VALUES
('Alice', 28, '123 Apple St'),
('Bob', 34, '456 Banana Ave'),
('Charlie', 22, '789 Cherry Blvd');
