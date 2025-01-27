CREATE TABLE test_table (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL
);

INSERT INTO test_table (name) VALUES ('Alice'), ('Bob'), ('Charlie');
