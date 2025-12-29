<?php
session_start();

// SEGURIDAD: Si no es admin, no puede estar aquí
if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'admin') {
    // Si no es admin, lo mandamos al dashboard o login con un mensaje
    header('Location: login.php?error=acceso_denegado');
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

<div class="register-card">
    <div class="logo-container">
        <img src="https://hotelwaye.com/wp-content/uploads/2021/10/logo-waye-white.png" alt="Logo Waye">
    </div>
    
    <h1>Nuevo Colaborador</h1>
    <p class="subtitle">Ingresa los datos para la nueva cuenta de usuario.</p>

    <?php if(isset($_GET['status']) && $_GET['status'] == 'success'): ?>
        <p style="color: green; text-align: center; font-size: 0.8rem;">¡Usuario creado correctamente!</p>
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
            <select id="area" name="area" required>
                <option value="" disabled selected>Selecciona un área</option>
                <option value="Recepción">Recepción</option>
                <option value="Administración">Administración</option>
                <option value="Ventas">Ventas</option>
                <option value="Mantenimiento">Mantenimiento</option>
                <option value="Ama de Llaves">Ama de Llaves</option>
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

    <div class="footer-links">
        <a href="login.php">¿Ya tienes cuenta? Inicia Sesión</a>
    </div>
</div>

</body>
</html>