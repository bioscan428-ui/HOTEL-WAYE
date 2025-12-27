<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
include 'includes/db.php'; 
date_default_timezone_set('America/Mexico_City');

$mensaje = ""; 

// 1. Capturamos el estado de la URL (Importante para mostrar las alertas)
if (isset($_GET['status'])) {
    if ($_GET['status'] == 'success') $mensaje = "exito";
    if ($_GET['status'] == 'error') $mensaje = "error";
}

// 2. Verificar la SESIÓN
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

// 3. Obtener datos del empleado
$id_empleado = $_SESSION['id_usuario'] ?? null; 
$nombre_empleado = $_SESSION['nombre_usuario'] ?? "Empleado";

// 4. PROCESAR EL FORMULARIO (Solo si es POST)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $nombre_cliente   = trim($_POST['nombre']);
    $telefono_cliente = trim($_POST['telefono']);
    $correo_cliente   = trim($_POST['correo']);

    if (empty($nombre_cliente) || empty($correo_cliente)) {
        header("Location: registro_cliente.php?status=error"); // Usamos status para ser consistentes
        exit();
    }

    try {
        $sql = "INSERT INTO CLIENTE (nombre, telefono, correo) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        
        $stmt->bind_param("sss", $nombre_cliente, $telefono_cliente, $correo_cliente);

        if ($stmt->execute()) {
            // Después de insertar, redirigimos con éxito
            header("Location: registro_cliente.php?status=success");
            exit();
        } else {
            header("Location: registro_cliente.php?status=error");
            exit();
        }
        
        $stmt->close();

    } catch (Exception $e) {
        die("Error en la base de datos: " . $e->getMessage());
    }
}
?>