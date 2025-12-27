<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
include 'includes/db.php'; 
date_default_timezone_set('America/Mexico_City');

$fecha_actual = date('Y-m-d');

// --- LÓGICA PARA OBTENER EL NOMBRE Y ID DEL USUARIO ---
$nombre_empleado = "Empleado no encontrado";
$id_empleado = null; // Inicializada a null

// 1. Verificar la SESIÓN: Si no hay 'usuario' en sesión, forzar login.
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php'); // Asegúrate de que esta sea tu página de login
    exit();
}
?>