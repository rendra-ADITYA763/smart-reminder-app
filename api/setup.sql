CREATE DATABASE IF NOT EXISTS smart_reminder;
USE smart_reminder;

CREATE TABLE IF NOT EXISTS habits (
    id INT AUTO_INCREMENT PRIMARY KEY,
    activity VARCHAR(255) NOT NULL,
    hour INT NOT NULL,
    completedToday TINYINT(1) DEFAULT 0,
    lastNotified INT DEFAULT -1
);

CREATE TABLE IF NOT EXISTS schedule (
    id INT AUTO_INCREMENT PRIMARY KEY,
    subject VARCHAR(255) NOT NULL,
    day VARCHAR(50) NOT NULL,
    time VARCHAR(50) NOT NULL
);

CREATE TABLE IF NOT EXISTS events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    date DATE NOT NULL,
    loc VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    type VARCHAR(50) NOT NULL,
    message TEXT NOT NULL,
    time VARCHAR(100) NOT NULL
);

CREATE TABLE IF NOT EXISTS user_profile (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL DEFAULT 'Stranger'
);

-- Insert initial profile if not exists
INSERT INTO user_profile (id, name) 
SELECT 1, 'Stranger' 
WHERE NOT EXISTS (SELECT 1 FROM user_profile WHERE id = 1);
