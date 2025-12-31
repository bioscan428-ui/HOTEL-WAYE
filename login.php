<?php
// Mostrar errores (quitar en producción)
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require_once __DIR__ . '/includes/db.php';

$error = "";

// Si ya hay sesión iniciada, redirigir
if (isset($_SESSION['usuario'])) {
    header("Location: dashboard.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario = trim($_POST['usuario']);
    $password = trim($_POST['password']);

    // CORRECCIÓN 1: Aseguramos que la consulta pida la columna 'tipo' e 'id_area'
    $sql = "SELECT id, usuario, nombre, tipo, id_area, contraseña FROM USUARIOS 
            WHERE usuario = ? 
            AND activo = 1 
            LIMIT 1";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $usuario); // Solo enviamos el usuario para verificar la clave después
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();

        // CORRECCIÓN 2: Verificación de contraseña (ajustada a tu método actual)
        // Si usas texto plano en la DB, dejamos $password === $row['contraseña']
        // Si usas password_hash, deberías usar password_verify($password, $row['contraseña'])
        if ($password === $row['contraseña']) {
            
            $_SESSION['id_usuario'] = $row['id'];
            $_SESSION['usuario']    = $row['usuario'];
            $_SESSION['nombre']     = $row['nombre'];
            $_SESSION['tipo'] = $row['tipo'] ?? $row['TIPO'] ?? 'error_no_encontrado'; // <--- AHORA SÍ SE GUARDA EL RANGO
            $_SESSION['id_area']    = $row['id_area']; // Guardamos el ID del área

            header("Location: dashboard.php");
            exit;
        } else {
            $error = "Usuario o contraseña incorrectos.";
        }
    } else {
        $error = "Usuario o contraseña incorrectos.";
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Acceso Colaboradores | Hotel WAYE</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="imagenes/favicon.png">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        :root{
            --accent:#d4a373;
            --dark:#1a1a1a;
        }

        *{box-sizing:border-box;margin:0;padding:0;}

        body{
            font-family:'Poppins',sans-serif;
            background:#f9f7f2;
        }

        /* HEADER */
        header{
            height:80px;
            background:var(--dark);
            display:flex;
            align-items:center;
            padding:0 40px;
            position:fixed;
            width:100%;
            top:0;
            z-index:1000;
        }

        .logo-box img{
            height:50px;
        }

        /* CONTENEDOR GENERAL */
        .login-wrapper{
            display:flex;
            height:100vh;
            margin-top:80px;
        }

        /* FORM */
        .login-form{
            width:25%;
            padding:60px 40px;
            background:white;
            display:flex;
            flex-direction:column;
            justify-content:center;
            border:4px solid #000;
        }


        .login-form h2{
            margin-bottom:25px;
            font-weight:600;
        }
        .login-title{
            text-align:center;
            font-weight:700;
        }

        .login-subtitle{
            text-align:center;
            font-size:14px;
            margin-bottom:30px;
        }
        .login-form form{
            display:flex;
            flex-direction:column;
            align-items:center;
        }

        .login-form input{
            width:100%;
            padding:14px 18px;
            border-radius:30px;
            border:1px solid #000;
            margin-bottom:15px;
            font-size:15px;
            background:white;
        }

        .password-wrapper{
            width:100%;
            position:relative;
        }

        .password-wrapper input{
            width:100%;
            padding-right:38px;
        }


        .toggle-password{
    position:absolute;
    top:0;
    right:14px;
    height:100%;
    display:flex;
    align-items:center;
    justify-content:center;
    cursor:pointer;
    font-size:13px;
    opacity:0.5;
    user-select:none;
}

        .toggle-password:hover{
            opacity:0.9;
        }

        .login-form button{
            width:100%;
            padding:14px;
            border:none;
            border-radius:30px;
            background:var(--accent);
            color:white;
            font-weight:600;
            cursor:pointer;
            transition:0.3s;
            margin-bottom:15px;
        }


        .login-form button:hover{
            background:#b88d5f;
        }

        .error{
            color:red;
            margin-top:10px;
            font-size:14px;
        }

        /* IMAGEN */
        .login-image{
            width:75%;
            min-height:100%;
            background-image:url('./imagenes/login.jpg');
            background-position:center;
            background-repeat:no-repeat;
            background-size:cover;
        }
        .remember-box{
            width:100%;
            margin-bottom:20px;
            font-size:14px;
            display:flex;
            justify-content:flex-start;
        }

        .remember-box label{
            display:inline-flex;
            align-items:center;
            gap:5px;
            cursor:pointer;
            white-space:nowrap;
        }

        .remember-box input{
            margin:0;
        }


        .link-back,
        .link-forgot{
            text-align:center;
            display:block;
            font-size:14px;
            margin-top:8px;
            color:var(--accent);
            text-decoration:none;
            font-weight:500;
        }

        .link-back:hover,
        .link-forgot:hover{
            text-decoration:underline;
        }

        /* MOBILE */
    @media(max-width:768px){
        header{
            justify-content:center;
        }

        .login-wrapper{
            position:relative;
            flex-direction:column;
            height:100vh;
        }

        .login-image{
            position:absolute;
            top:0;
            left:0;
            width:100%;
            height:100%;
            z-index:1;
        }

        .login-form{
            width:90%;
            max-width:360px;
            position:absolute;
            top:50%;
            left:50%;
            transform:translate(-50%,-50%);
            z-index:2;
            border-radius:20px;
            background:white;
            box-shadow:0 10px 30px rgba(0,0,0,0.4);
            padding: 40px 25px; /* Reducir padding en móvil */
        }
        
        /* Ajustes específicos para el checkbox en móvil */
        .remember-box{
            margin-bottom:15px;
            display:flex;
            justify-content:flex-start;
            width:100%;
        }

        .remember-box label{
            display:inline-flex;
            align-items:center;
            gap:6px; /* Reducir espacio entre checkbox y texto */
            cursor:pointer;
            white-space:nowrap;
            font-size:13px;
            line-height:1.2;
        }

        .remember-box input[type="checkbox"]{
            width:14px;
            height:14px;
            margin:0;
            flex-shrink:0;
        }
        
        /* Ajustar tamaño de inputs en móvil */
        .login-form input{
            padding:12px 16px;
            font-size:14px;
        }
        
        .password-wrapper input{
            padding-right:38px;
        }
        
        .toggle-password{
            font-size:12px;
        }
    }

    </style>
</head>
<body>

<header>
    <div class="logo-box">
        <img src="imagenes/waye.png" alt="Hotel Waye">
    </div>
</header>

<div class="login-wrapper">
    <div class="login-form">
            <h2 class="login-title">Acceso Colaboradores</h2>
                <p class="login-subtitle">
                    Ingrese su usuario y contraseña para poder continuar
                </p>
                <form method="POST">

                <input type="text" name="usuario" placeholder="Usuario" required>
                <div class="password-wrapper">
                    <input type="password" name="password" id="password" placeholder="Contraseña" required>
                    <span class="toggle-password" onclick="togglePassword()">👁</span>
                </div>


                <div class="remember-box">
                <label>
                    <input type="checkbox" name="remember">
                    Mantener sesión abierta
                </label>
            </div>

                <button type="submit">Ingresar</button>
                <a href="waye.php" class="link-back">Volver al inicio</a>
                <a href="recuperar_contraseña.php" class="link-forgot">
                    ¿Olvidaste tu contraseña?
                </a>


                <?php if($error): ?>
                    <div class="error"><?php echo $error; ?></div>
                <?php endif; ?>
            </form>
    </div>

    <div class="login-image"></div>
</div>
<script>
function togglePassword(){
    const input = document.getElementById('password');
    input.type = input.type === 'password' ? 'text' : 'password';
}
</script>

</body>
</html>