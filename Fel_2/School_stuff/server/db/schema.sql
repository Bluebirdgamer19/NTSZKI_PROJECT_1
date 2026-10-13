CREATE DATABASE IF NOT EXISTS `fel_2`
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE `fel_2`;

CREATE TABLE IF NOT EXISTS `registrations` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `full_name` VARCHAR(255) NOT NULL,
    `school_name` VARCHAR(255) NOT NULL,
    `is_dormitory` TINYINT(1) NOT NULL,
    `is_final_year` TINYINT(1) NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `registration_interests` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `registration_id` INT NOT NULL,
    `interest_name` VARCHAR(255) NOT NULL,
    CONSTRAINT `fk_registration_interest_registration`
        FOREIGN KEY (`registration_id`) REFERENCES `registrations` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
