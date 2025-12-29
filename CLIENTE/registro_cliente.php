<?php
require_once 'controllers/registro_cliente_logica.php'
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Cliente - Hotel WAYE</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #1a1a1a;
            --accent: #d4a373;
            --bg: #f9f7f2;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg);
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 450px;
            text-align: center;
        }

        h1 {
            font-family: 'Playfair Display', serif;
            color: var(--primary);
            margin-bottom: 10px;
        }

        p { color: #666; margin-bottom: 30px; font-size: 0.9rem; }

        .form-group {
            text-align: left;
            margin-bottom: 15px;
        }

        label {
            display: block;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
            margin-bottom: 5px;
            color: var(--primary);
        }

        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-sizing: border-box;
            font-family: 'Poppins';
            transition: border 0.3s;
        }

        input:focus {
            outline: none;
            border-color: var(--accent);
        }

        .btn-enviar {
            background-color: var(--primary);
            color: white;
            border: none;
            padding: 15px;
            width: 100%;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            letter-spacing: 1px;
            transition: background 0.3s;
            margin-top: 10px;
        }

        .btn-enviar:hover {
            background-color: var(--accent);
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            font-size: 0.9rem;
        }

        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        
        .back-link {
            display: inline-block;
            margin-top: 20px;
            color: var(--primary);
            text-decoration: none;
            font-size: 0.8rem;
            border-bottom: 1px solid var(--accent);
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Hotel WAYE</h1>
    <p>Regístrate para recibir atención personalizada</p>

    <?php if ($mensaje == "exito"): ?>
        <div class="alert alert-success">¡Registro completado con éxito!</div>
    <?php elseif ($mensaje == "error"): ?>
        <div class="alert alert-error">Hubo un problema al guardar los datos.</div>
    <?php endif; ?>

    <form action="registro_cliente.php" method="POST">
        <div class="form-group">
            <label>Nombre Completo</label>
            <input type="text" name="nombre" placeholder="Ej. Juan Pérez" required>
        </div>

        <div class="form-group">
            <label>Teléfono</label>
            <input type="tel" name="telefono" placeholder="Ej. 985 123 4567">
        </div>

        <div class="form-group">
            <label>Correo Electrónico</label>
            <input type="email" name="correo" placeholder="juan@ejemplo.com" required>
        </div>

        <button type="submit" class="btn-enviar">CONFIRMAR REGISTRO</button>
    </form>

    <a href="waye.php" class="back-link">Regresar al Inicio</a>
</div>

</body>
</html>