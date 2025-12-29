<?php
session_start();
require_once __DIR__ . '/../includes/db.php';

// 1. SEGURIDAD: Solo admin puede eliminar
if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'admin') {
    die("Acceso denegado.");
}

// 2. Verificar que recibimos un ID válido
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_a_eliminar = $_GET['id'];

    // 3. Evitar que el admin se elimine a sí mismo
    if ($id_a_eliminar == $_SESSION['id_usuario']) {
        header("Location: ../ver_empleados.php?error=self_delete");
        exit;
    }

    // 4. Ejecutar la eliminación
    $sql = "DELETE FROM USUARIOS WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_a_eliminar);

    if ($stmt->execute()) {
        header("Location: ../ver_empleados.php?status=deleted");
    } else {
        echo "Error al eliminar: " . $conn->error;
    }
    $stmt->close();
} else {
    header("Location: ../ver_empleados.php");
}
?>