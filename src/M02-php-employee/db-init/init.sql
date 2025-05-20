-- Create users table
CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(255) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create employees table
CREATE TABLE IF NOT EXISTS employees (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(255) NOT NULL UNIQUE,
  position VARCHAR(100) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert admin user (email: admin@example.com, password: admin123)
INSERT INTO users (email, password) VALUES
('admin@example.com', '$2b$12$Qema89yZUNvUcvpiZqJaiO16UXh6L9Vu4dQL8I0wGmEqOfZvaWZR.');

-- (Optional) insert a sample employee
INSERT INTO employees (name, email, position) VALUES
('John Doe', 'john.doe@example.com', 'Developer');
