<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require_once __DIR__ . '/includes/db.php';

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

// --- LÓGICA DE DATOS PARA EL ADMIN ---
$total_usuarios = 0;
$usuarios_activos = 0;
$tipo_usuario = $_SESSION['tipo'] ?? 'normal';

if ($tipo_usuario === 'admin') {
    // 1. Contar total de colaboradores
    $res1 = $conn->query("SELECT COUNT(*) as total FROM USUARIOS");
    $total_usuarios = $res1->fetch_assoc()['total'];

    // 2. Contar colaboradores activos
    $res2 = $conn->query("SELECT COUNT(*) as activos FROM USUARIOS WHERE activo = 1");
    $usuarios_activos = $res2->fetch_assoc()['activos'];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard | Hotel WAYE</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="imagenes/favicon.png">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        :root {
            --accent: #d4a373;
            --dark: #1a1a1a;
            --bg: #f9f7f2;
        }

        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background: var(--bg);
        }

        .contenido {
            margin-top: 100px; /* Espacio para el header fijo */
            padding: 20px;
            max-width: 1200px;
            margin-left: auto;
            margin-right: auto;
        }

        .welcome-box {
            text-align: center;
            margin-bottom: 40px;
        }

        .welcome-box h1 {
            color: var(--dark);
            margin: 10px 0;
        }

        .role-badge {
            background: var(--accent);
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Contenedor de Tarjetas */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            border-left: 5px solid var(--accent);
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card h3 {
            margin: 0;
            font-size: 0.9rem;
            color: #666;
            text-transform: uppercase;
        }

        .card .number {
            font-size: 2rem;
            font-weight: 600;
            color: var(--dark);
            margin: 10px 0;
        }

        .card a {
            color: var(--accent);
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .card a:hover {
            text-decoration: underline;
        }

        /* Vista para usuario normal */
        .normal-view {
            background: white;
            padding: 50px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        }
    </style>
</head>
<body>

<?php include __DIR__ . '/includes/header.php'; ?>

<div class="contenido">
    
    <div class="welcome-box">
        <span class="role-badge"><?php echo htmlspecialchars($tipo_usuario); ?></span>
        <h1>Bienvenido, <?php echo htmlspecialchars($_SESSION['nombre']); ?></h1>
        <p>Panel de Gestión Hotelera - Hotel WAYE</p>
    </div>

    <?php if ($tipo_usuario === 'admin'): ?>
        <div class="stats-grid">
            
            <div class="card">
                <h3>Colaboradores Totales</h3>
                <div class="number"><?php echo $total_usuarios; ?></div>
                <a href="ver_empleados.php">Gestionar equipo →</a>
            </div>

            <div class="card" style="border-left-color: #28a745;">
                <h3>Usuarios Activos</h3>
                <div class="number"><?php echo $usuarios_activos; ?></div>
                <p style="margin:0; font-size: 0.8rem; color: #28a745;">● Actualmente habilitados</p>
            </div>

            <div class="card" style="border-left-color: var(--dark);">
                <h3>Acceso Rápido</h3>
                <div style="margin-top: 15px; display: flex; flex-direction: column; gap: 8px;">
                    <a href="registro_empleados.php"> Crear nuevo usuario</a>
                    <a href="ver_clientes.php"> Revisar huéspedes</a>
                </div>
            </div>

        </div>
    <?php else: ?>
        <div class="normal-view">
            <h2>Hola, <?php echo explode(' ', $_SESSION['nombre'])[0]; ?></h2>
            <p>Tienes acceso al panel de registro de clientes y consultas.</p>
            <p>Si necesitas ayuda con tus permisos, contacta a Gerencia.</p>
            <img src="imagenes/waye.png" alt="Logo" style="height: 50px; opacity: 0.1; margin-top: 20px;">
        </div>
    <?php endif; ?>

</div>

</body>
</html>