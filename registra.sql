-- MySQL Script: registra.sql
-- Purpose: Create database and student table

-- Drop database if it exists (optional - remove if you want to keep existing data)
DROP DATABASE IF EXISTS db_registra;

-- Create the database
CREATE DATABASE db_registra;

-- Use the database
USE db_registra;

-- Create the student table
CREATE TABLE tbl_student (
    st_ID INT PRIMARY KEY AUTO_INCREMENT,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    birth_date DATE NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Display table structure
DESCRIBE tbl_student;

-- Optional: Insert sample data for testing
-- INSERT INTO tbl_student (first_name, last_name, birth_date, email) 
-- VALUES 
-- ('John', 'Doe', '2000-05-15', 'john.doe@email.com'),
-- ('Jane', 'Smith', '1999-08-22', 'jane.smith@email.com');