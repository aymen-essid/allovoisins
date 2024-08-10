CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    firstName VARCHAR(50),
    lastName VARCHAR(50),
    email VARCHAR(100) UNIQUE,
    phone VARCHAR(20),
    postalAddress TEXT,
    professionalStatus VARCHAR(50),
    lastLogin DATETIME
);
