<?php
$host = "localhost"; // O el host que te indique GoDaddy (ej. '127.0.0.1' o 'mysql.secureserver.net')
$db = "hotelwaye";  // <-- cambia esto
$user = "user_waye"; // <-- cambia esto
$pass = "Hotelwaye2025"; // <-- cambia esto

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Forzar uso de UTF-8 para evitar problemas con tildes como "Sí"
$conn->set_charset('utf8mb4');
?>


