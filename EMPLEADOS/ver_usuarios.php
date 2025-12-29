<?php
session_start();
require_once __DIR__ . '/includes/db.php';

// SEGURIDAD: Solo usuarios autenticados pueden ver la lista
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

// Consultar empleados
$sql = "SELECT id, nombre, usuario, area, tipo, activo FROM USUARIOS ORDER BY nombre ASC";
$resultado = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personal - Hotel WAYE</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        :root { --accent: #d4a373; --dark: #1a1a1a; --danger: #e74c3c; --info: #3498db; }
        body { font-family: 'Poppins', sans-serif; background: #f9f7f2; margin: 0; }
        
        .main-container { padding: 100px 40px 40px; max-width: 1200px; margin: 0 auto; }
        
        .header-flex { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        h1 { margin: 0; color: var(--dark); font-weight: 600; }

        .btn-add { 
            background: var(--accent); color: white; padding: 10px 20px; 
            text-decoration: none; border-radius: 25px; font-size: 14px; transition: 0.3s;
        }
        .btn-add:hover { background: #b88d5f; }

        /* Estilos de la Tabla */
        .table-card { background: white; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); overflow: hidden; }
        table { width: 100%; border-collapse: collapse; }
        thead { background: var(--dark); color: white; }
        th, td { padding: 15px 20px; text-align: left; border-bottom: 1px solid #eee; }
        tr:hover { background-color: #fcfaf7; }

        /* Badges de Roles */
        .badge { padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; text-transform: uppercase; }
        .badge-admin { background: #e3f2fd; color: #1976d2; }
        .badge-normal { background: #f5f5f5; color: #616161; }
        
        /* Botones de Acción */
        .btn-action { 
            padding: 6px 12px; border-radius: 4px; text-decoration: none; 
            font-size: 12px; color: white; font-weight: 600; margin-right: 5px;
            display: inline-block;
        }
        .btn-edit { background: var(--info); }
        .btn-delete { background: var(--danger); }

        /* Buscador */
        #searchInput {
            width: 100%; padding: 12px 20px; margin-bottom: 20px;
            border: 1px solid #ddd; border-radius: 8px; font-family: inherit;
        }
    </style>
</head>
<body>

<?php include __DIR__ . '/includes/header.php'; ?>

<div class="main-container">
    <div class="header-flex">
        <h1>Colaboradores</h1>
        <?php if($_SESSION['tipo'] === 'admin'): ?>
            <a href="registro_empleados.php" class="btn-add">+ Nuevo Colaborador</a>
        <?php endif; ?>
    </div>

    <input type="text" id="searchInput" placeholder="Buscar por nombre, usuario o área...">

    <div class="table-card">
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Usuario</th>
                    <th>Área</th>
                    <th>Rango</th>
                    <th>Estado</th>
                    <?php if($_SESSION['tipo'] === 'admin'): ?>
                        <th>Acciones</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody id="employeeTable">
                <?php while($row = $resultado->fetch_assoc()): ?>
                <tr>
                    <td><strong><?php echo htmlspecialchars($row['nombre']); ?></strong></td>
                    <td>@<?php echo htmlspecialchars($row['usuario']); ?></td>
                    <td><?php echo htmlspecialchars($row['area']); ?></td>
                    <td>
                        <span class="badge <?php echo ($row['tipo'] === 'admin') ? 'badge-admin' : 'badge-normal'; ?>">
                            <?php echo $row['tipo']; ?>
                        </span>
                    </td>
                    <td>
                        <span style="color: <?php echo $row['activo'] ? '#2ecc71' : '#e74c3c'; ?>;">
                            ● <?php echo $row['activo'] ? 'Activo' : 'Inactivo'; ?>
                        </span>
                    </td>
                    <?php if($_SESSION['tipo'] === 'admin'): ?>
                    <td>
                        <a href="editar_empleado.php?id=<?php echo $row['id']; ?>" class="btn-action btn-edit">Editar</a>
                        
                        <?php if($row['id'] != $_SESSION['id_usuario']): ?>
                            <a href="controllers/eliminar_empleado.php?id=<?php echo $row['id']; ?>" 
                               class="btn-action btn-delete" 
                               onclick="return confirm('¿Estás seguro de eliminar a este colaborador?')">
                               Eliminar
                            </a>
                        <?php endif; ?>
                    </td>
                    <?php endif; ?>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    // Filtro de búsqueda en tiempo real
    document.getElementById('searchInput').addEventListener('keyup', function() {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll('#employeeTable tr');
        
        rows.forEach(row => {
            let text = row.innerText.toLowerCase();
            row.style.display = text.includes(filter) ? '' : 'none';
        });
    });
</script>

</body>
</html>