<?php
session_start();
require_once __DIR__ . '/includes/db.php';

if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'admin') {
    header("Location: dashboard.php");
    exit;
}

// Obtener datos del empleado a editar
$id = $_GET['id'];
$sql = "SELECT * FROM USUARIOS WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$empleado = $stmt->get_result()->fetch_assoc();

if (!$empleado) { die("Empleado no encontrado."); }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Colaborador - Hotel WAYE</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background: #f9f7f2; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .form-card { background: white; padding: 30px; border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); width: 400px; }
        h2 { color: #1a1a1a; margin-top: 0; }
        input, select { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box; }
        .btn-save { background: #d4a373; color: white; border: none; width: 100%; padding: 12px; border-radius: 8px; cursor: pointer; font-weight: 600; }
    </style>
</head>
<body>

<div class="form-card">
    <h2>Editar Colaborador</h2>
    <form action="controllers/actualizar_empleado_logica.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $empleado['id']; ?>">
        
        <label>Nombre Completo</label>
        <input type="text" name="nombre" value="<?php echo htmlspecialchars($empleado['nombre']); ?>" required>
        
        <label>Área</label>
        <input type="text" name="area" value="<?php echo htmlspecialchars($empleado['area']); ?>" required>
        
        <label>Rango</label>
        <select name="tipo">
            <option value="normal" <?php echo ($empleado['tipo'] == 'normal') ? 'selected' : ''; ?>>Normal</option>
            <option value="admin" <?php echo ($empleado['tipo'] == 'admin') ? 'selected' : ''; ?>>Administrador</option>
        </select>

        <button type="submit" class="btn-save">Guardar Cambios</button>
        <a href="ver_empleados.php" style="display: block; text-align: center; margin-top: 15px; color: #777; font-size: 13px;">Cancelar</a>
    </form>
</div>

</body>
</html>