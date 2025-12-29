<?php
session_start();
include 'includes/db.php';

// 1. Seguridad: Solo usuarios logueados
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

// 2. Lógica del Buscador
$busqueda = isset($_GET['buscar']) ? trim($_GET['buscar']) : '';

// 3. Consulta SQL dinámica
if (!empty($busqueda)) {
    // Buscamos coincidencia en nombre o correo
    $sql = "SELECT id, nombre, telefono, correo FROM CLIENTE 
            WHERE nombre LIKE ? OR correo LIKE ? 
            ORDER BY id DESC";
    $stmt = $conn->prepare($sql);
    $termino = "%$busqueda%";
    $stmt->bind_param("ss", $termino, $termino);
    $stmt->execute();
    $resultado = $stmt->get_result();
} else {
    // Si no hay búsqueda, mostramos todos
    $sql = "SELECT id, nombre, telefono, correo FROM CLIENTE ORDER BY id DESC";
    $resultado = $conn->query($sql);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Clientes - Hotel WAYE</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        :root { --primary: #1a1a1a; --accent: #d4a373; --bg: #f9f7f2; }
        body { font-family: 'Poppins', sans-serif; background-color: var(--bg); padding: 40px 20px; margin: 0; }
        .container { max-width: 1000px; margin: auto; background: white; padding: 30px; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
        
        header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        h1 { font-family: 'Playfair Display', serif; color: var(--primary); margin: 0; }

        /* Estilos del Buscador */
        .search-container { margin-bottom: 30px; display: flex; gap: 10px; }
        .search-input { 
            flex-grow: 1; padding: 12px 20px; border: 1px solid #ddd; 
            border-radius: 8px; font-family: 'Poppins'; font-size: 0.9rem;
        }
        .btn-search { 
            background: var(--primary); color: white; border: none; 
            padding: 10px 25px; border-radius: 8px; cursor: pointer; font-weight: 600;
        }
        .btn-search:hover { background: var(--accent); }
        
        table { width: 100%; border-collapse: collapse; }
        table th { text-align: left; background: var(--bg); padding: 15px; font-size: 0.8rem; letter-spacing: 1px; }
        table td { padding: 15px; border-bottom: 1px solid #eee; font-size: 0.95rem; }
        .badge-id { background: var(--accent); color: white; padding: 2px 8px; border-radius: 4px; font-size: 0.8rem; }
        .no-data { text-align: center; padding: 40px; color: #999; }
    </style>
</head>
<body>

<div class="container">
    <header>
        <h1>Registro de Clientes</h1>
        <a href="waye.php" style="text-decoration:none; color:var(--primary); font-size:0.8rem; border-bottom:1px solid var(--accent);">Ir al Inicio</a>
    </header>

    <form action="ver_clientes.php" method="GET" class="search-container">
        <input type="text" name="buscar" class="search-input" 
               placeholder="Buscar por nombre o correo..." 
               value="<?php echo htmlspecialchars($busqueda); ?>">
        <button type="submit" class="btn-search">BUSCAR</button>
        <?php if(!empty($busqueda)): ?>
            <a href="ver_clientes.php" style="line-height:45px; color:#999; font-size:0.8rem;">Limpiar</a>
        <?php endif; ?>
    </form>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Teléfono</th>
                <th>Correo</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($resultado && $resultado->num_rows > 0): ?>
                <?php while($fila = $resultado->fetch_assoc()): ?>
                    <tr>
                        <td><span class="badge-id"><?php echo $fila['id']; ?></span></td>
                        <td><strong><?php echo htmlspecialchars($fila['nombre']); ?></strong></td>
                        <td><?php echo htmlspecialchars($fila['telefono'] ?: 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($fila['correo']); ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="no-data">No se encontraron clientes que coincidan con la búsqueda.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>