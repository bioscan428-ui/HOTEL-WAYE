<?php
session_start();
require_once __DIR__ . '/../includes/db.php';

// 1. SEGURIDAD: Solo admin
if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'admin') {
    die("Acceso denegado.");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id     = $_POST['id'];
    $nombre = trim($_POST['nombre']);
    $area   = trim($_POST['area']);
    $tipo   = $_POST['tipo'];

    // 2. Actualizamos los datos (sin tocar la contraseña)
    $sql = "UPDATE USUARIOS SET nombre = ?, area = ?, tipo = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $nombre, $area, $tipo, $id);

    if ($stmt->execute()) {
        // 3. Si el admin se editó a sí mismo, actualizamos su sesión para que no lo saque
        if ($id == $_SESSION['id_usuario']) {
            $_SESSION['nombre'] = $nombre;
            $_SESSION['tipo']   = $tipo;
        }
        
        header("Location: ../ver_empleados.php?status=updated");
        exit;
    } else {
        echo "Error al actualizar: " . $conn->error;
    }

    $stmt->close();
}
?>