<?php
// 1. Iniciar sesión solo si no ha empezado
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. Incluir conexión
include '../includes/db.php';

// 3. VALIDACIÓN DEFINITIVA
// Usamos trim para limpiar espacios y strtolower para evitar problemas con ADMIN vs admin
$tipo_usuario = isset($_SESSION['tipo']) ? strtolower(trim($_SESSION['tipo'])) : '';

if ($tipo_usuario !== 'admin') {
    die("Acceso denegado: Tu rango actual es [" . $tipo_usuario . "] y se requiere [admin].");
}

// 4. PROCESAR EL REGISTRO
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre    = $_POST['nombre'];
    $usuario   = $_POST['usuario'];
    $password  = $_POST['contrasena']; // Texto plano
    $area      = $_POST['area'];
    $tipo_nuevo = $_POST['tipo']; // El rango que le daremos al nuevo usuario

    $sql = "INSERT INTO USUARIOS (nombre, usuario, contraseña, area, tipo, activo) 
            VALUES (?, ?, ?, ?, ?, 1)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $nombre, $usuario, $password, $area, $tipo_nuevo);

    if ($stmt->execute()) {
        // Éxito: Volver al formulario con mensaje
        header("Location: ../registro_empleados.php?status=success");
        exit();
    } else {
        echo "Error al guardar: " . $conn->error;
    }

    $stmt->close();
}
?>