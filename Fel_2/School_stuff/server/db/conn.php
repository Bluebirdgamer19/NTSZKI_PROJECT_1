<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fel_2";

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    // Connect without selecting a database so the application can provision it.
    $conn = new mysqli($servername, $username, $password);
    $conn->set_charset("utf8mb4");
    $conn->query(
        "CREATE DATABASE IF NOT EXISTS `" . $conn->real_escape_string($dbname) .
        "` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci"
    );
    $conn->select_db($dbname);

    $conn->query("CREATE TABLE IF NOT EXISTS registrations (
        id INT AUTO_INCREMENT PRIMARY KEY,
        full_name VARCHAR(255) NOT NULL,
        school_name VARCHAR(255) NOT NULL,
        is_dormitory TINYINT(1) NOT NULL,
        is_final_year TINYINT(1) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

    $conn->query("CREATE TABLE IF NOT EXISTS registration_interests (
        id INT AUTO_INCREMENT PRIMARY KEY,
        registration_id INT NOT NULL,
        interest_name VARCHAR(255) NOT NULL,
        CONSTRAINT fk_registration_interest_registration
            FOREIGN KEY (registration_id) REFERENCES registrations(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
} catch (mysqli_sql_exception $exception) {
    http_response_code(500);
    die("Database initialization failed: " . $exception->getMessage());
}