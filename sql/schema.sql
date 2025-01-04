-- Crear la base de datos
CREATE DATABASE alojamientos;

-- Usar la base de datos
USE alojamientos;

-- Tabla de usuarios
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') NOT NULL DEFAULT 'user',
    created TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de alojamientos
CREATE TABLE accommodations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    location VARCHAR(150) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    description TEXT,
    image_url VARCHAR(255),
    created TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de relación entre usuarios y alojamientos
CREATE TABLE user_accommodations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    accommodation_id INT NOT NULL,
    added TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE, -- Relación con la tabla users
    FOREIGN KEY (accommodation_id) REFERENCES accommodations(id) ON DELETE CASCADE -- Relación con la tabla accommodations
);

-- Verificación de las tablas creadas
#SHOW TABLES;
