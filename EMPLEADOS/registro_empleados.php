<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

// SEGURIDAD PROBADA
if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'admin') {
    header('Location: dashboard.php?error=no_admin');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Colaboradores - Hotel WAYE</title>
    <link href="css/registro_empleados.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>

<?php include __DIR__ . '/includes/header.php'; ?>

<div class="register-card" style="margin-top: 100px;">
    <div class="logo-container">
        <img src="https://hotelwaye.com/wp-content/uploads/2021/10/logo-waye-white.png" alt="Logo Waye">
    </div>
    
    <h1>Nuevo Colaborador</h1>
    <p class="subtitle">Ingresa los datos para la nueva cuenta de usuario.</p>

    <?php if(isset($_GET['status']) && $_GET['status'] == 'success'): ?>
        <p style="color: #28a745; text-align: center; font-weight: bold;">¡Usuario creado correctamente!</p>
    <?php endif; ?>

    <form action="controllers/registro_empleados_logica.php" method="POST">
        <div class="form-group">
            <label for="nombre">Nombre Completo</label>
            <input type="text" id="nombre" name="nombre" placeholder="Nombre y Apellidos" required>
        </div>

        <div class="form-group">
            <label for="usuario">Nombre de Usuario</label>
            <input type="text" id="usuario" name="usuario" placeholder="usuario_waye" required>
        </div>

        <div class="form-group">
            <label for="contrasena">Contraseña</label>
            <input type="password" id="contrasena" name="contrasena" placeholder="••••••••" required>
        </div>

        <div class="form-group">
            <label for="area">Área / Departamento</label>
            <select id="area" name="id_area" required>
                <option value="" disabled selected>Selecciona un área</option>
                <option value="1">Recepción</option>
                <option value="2">Administración</option>
                <option value="3">Ventas</option>
                <option value="4">Mantenimiento</option>
                <option value="5">Limpieza</option>
            </select>
        </div>

        <div class="form-group">
            <label for="tipo">Nivel de Permisos</label>
            <select id="tipo" name="tipo" required>
                <option value="normal">Colaborador Normal</option>
                <option value="admin">Administrador</option>
            </select>
        </div>

        <button type="submit" class="btn-register">Crear Cuenta</button>
    </form>
</div>

</body>
</html>