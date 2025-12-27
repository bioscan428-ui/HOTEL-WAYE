<?php
// 1. Configuración de errores y sesión
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();

// 2. Incluir conexión a la base de datos
// Asegúrate de que la ruta sea correcta desde la carpeta 'controllers'
include '../includes/db.php'; 

// 3. SEGURIDAD: Solo administradores pueden procesar este formulario
if (!isset($_SESSION['usuario']) || !isset($_SESSION['area'])) {
    header('Location: ../login.php');
    exit();
}

// Validar que el área sea Administración (considerando acentos)
$area_usuario = $_SESSION['area'];
if ($area_usuario !== 'Administración' && $area_usuario !== 'Administracion') {
    die("Acceso denegado: No tienes permisos de administrador para registrar personal.");
}

// 4. Procesar el formulario cuando se recibe por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Limpiar y recibir datos
    $nombre    = trim($_POST['nombre']);
    $usuario   = trim($_POST['usuario']);
    $password  = $_POST['contrasena']; // La contraseña original
    $area_dest = $_POST['area'];      // El área asignada al nuevo empleado

    // Validación simple de campos vacíos
    if (empty($nombre) || empty($usuario) || empty($password) || empty($area_dest)) {
        header("Location: ../registro_empleado.php?status=error_vacios");
        exit();
    }

    // 5. ENCRIPTACIÓN: Nunca guardar contraseñas en texto plano
    // password_hash genera una cadena segura de 60 caracteres
    $password_fuerte = password_hash($password, PASSWORD_BCRYPT);

    try {
        // 6. Preparar la consulta SQL (Usando tu tabla USUARIOS)
        // Nota: El campo 'activo' tiene DEFAULT TRUE, no hace falta ponerlo
        $sql = "INSERT INTO USUARIOS (nombre, usuario, contraseña, area) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        
        // "ssss" significa que los 4 parámetros son Strings
        $stmt->bind_param("ssss", $nombre, $usuario, $password_fuerte, $area_dest);

        if ($stmt->execute()) {
            // Éxito: Redirigir al registro con mensaje de confirmación
            header("Location: ../registro_empleado.php?status=success");
            exit();
        } else {
            // Error al insertar (ej. usuario duplicado)
            header("Location: ../registro_empleado.php?status=error_db");
            exit();
        }

        $stmt->close();

    } catch (Exception $e) {
        // Manejo de errores específicos (como duplicados)
        if ($conn->errno == 1062) {
             header("Location: ../registro_empleado.php?status=error_duplicado");
        } else {
             die("Error crítico: " . $e->getMessage());
        }
        exit();
    }

} else {
    // Si intentan entrar al script directamente sin POST
    header('Location: ../registro_empleado.php');
    exit();
}
?>