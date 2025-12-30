<?php
session_start();
require_once __DIR__ . '/../includes/db.php';

if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'admin') {
    die("Acceso denegado");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre    = $_POST['nombre'];
    $usuario   = $_POST['usuario'];
    $password  = $_POST['contrasena']; 
    $id_area   = $_POST['id_area']; // Asegúrate de que coincida con el name del select
    $tipo      = $_POST['tipo'];

    // Nota la "i" en el bind_param para el id_area
    $sql = "INSERT INTO USUARIOS (nombre, usuario, contraseña, id_area, tipo, activo) 
            VALUES (?, ?, ?, ?, ?, 1)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssis", $nombre, $usuario, $password, $id_area, $tipo);

    if ($stmt->execute()) {
        header("Location: ../registro_empleados.php?status=success");
        exit();
    } else {
        die("Error en la ejecución: " . $stmt->error . " | Error de conexión: " . $conn->error);
    }
}
?>