<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Configuración de Identidad del Hotel
$nombre_hotel = "Hotel WAYE";
$logo_url = "imagenes/waye.png";
$fondo_hero = "imagenes/hotel.png";
$color_acento = "#d4a373"; // Tono arena/dorado del hotel
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title><?php echo $nombre_hotel; ?> Hotel WAYE</title>
    <link rel="icon" href="imagenes/favicon.png" type="image/png" >
   
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet" />
    
    <style>
        :root {
            --primary: #1a1a1a;
            --accent: <?php echo $color_acento; ?>;
            --text-light: #ffffff;
            --bg-soft: #f9f7f2;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }
        
        body { 
            font-family: 'Poppins', sans-serif; 
            background-color: var(--bg-soft);
            color: #333; 
        }

        /* HEADER: Basado exactamente en tu imagen de Bioscan */
        header { 
            background: var(--primary); 
            color: var(--text-light); 
            padding: 0 40px; 
            display: flex; 
            align-items: center; 
            justify-content: space-between; 
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3); 
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            height: 80px; /* Altura fija para todo el header */
        }
        .logo-box { 
            width: 150px; 
            display: flex;
            align-items: center;
            height: 100%;
        }
        .logo-box img { 
            height: 50px; 
            object-fit: contain; 
        }

        .titulo-header { 
            display: none; /* Ocultar completamente */
        }

        /* Botón de Reservar (CTA derecho) */
        .cta-button { 
            background: var(--accent); 
            color: white; 
            padding: 12px 32px; 
            border-radius: 50px; 
            text-decoration: none; 
            font-weight: 600; 
            font-size: 16px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(212, 163, 115, 0.3);
            display: flex;
            align-items: center;
            height: fit-content;
        }



        .cta-button:hover { 
            background: #b88d5f;
            transform: translateY(-2px);
        }

        /* Navegación Inferior del Header */
        nav { 
            display: flex; 
            align-items: center;
            gap: 30px; 
            height: 100%;
        }

        nav a { 
            color: var(--text-light); 
            text-decoration: none; 
            font-weight: 500; 
            font-size: 15px;
            text-transform: uppercase;
            letter-spacing: 2.5px;
            transition: color 0.3s; 
        }


        nav a:hover { color: var(--accent); }

        /* SECCIÓN HERO */
        .hero { 
            height: 100vh; 
            background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), 
                        url('<?php echo $fondo_hero; ?>') center/cover no-repeat; 
            display: flex; 
            flex-direction: column; 
            justify-content: center; 
            align-items: center; 
            text-align: center; 
            margin-top: 80px; /* Igual a la altura del header */
        }

        .hero h1 { 
            color: white; 
            font-family: 'Playfair Display', serif;
            font-size: 3.2rem; 
            max-width: 850px; 
            margin-bottom: 25px;
        }

        .hero .btn-main { 
            padding: 15px 40px; 
            background: transparent;
            color: white; 
            border: 2px solid var(--accent); 
            border-radius: 5px; 
            font-size: 1.1rem; 
            cursor: pointer; 
            transition: all 0.3s; 
            text-decoration: none;
        }

        .hero .btn-main:hover { 
            background: var(--accent);
            color: black;
        }

        /* CARDS (Basadas en Bioscan) */
        .servicios-sec { padding: 100px 20px; max-width: 1200px; margin: auto; }
        
        .grid-cards { 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); 
            gap: 20px; 
            margin-top: 50px; 
        }

        .card-waye { 
            background: white; 
            padding: 40px 20px; 
            text-align: center; 
            border: 1px solid #eee;
            transition: 0.3s; 
        }

        .card-waye:hover { border-color: var(--accent); transform: translateY(-5px); }
        .card-waye h3 { font-family: 'Playfair Display', serif; margin-bottom: 15px; }

        footer { background: var(--primary); color: white; text-align: center; padding: 40px; margin-top: 50px; }

        @media (max-width: 768px) {
            .titulo-header { display: none; } /* Ocultar título en móvil para no amontonar */
            .hero h1 { font-size: 2rem; }
        }
    </style>
</head>
<body>

<header>
    <div class="logo-box">
        <img src="<?php echo $logo_url; ?>" alt="Logo Waye">
    </div>
    
    <nav>
        <a href="login.php" style="color: var(--accent); font-weight: 600;">Acceso Colaboradores</a>
        <a href="#hotel">El Hotel</a>
        <a href="#contacto">Contacto</a>
    </nav>
    
    <a href="https://waye.mx" class="cta-button">RESERVAR</a>
</header>

<section class="hero">
    <h1>Conecta con tu origen en el corazón de Yucatán</h1>
    <a href="registro_cliente.php" class="btn-main">Descubrir Experiencias</a>
</section>

<main class="servicios-sec" id="servicios">
    <h2 style="text-align:center; font-family:'Playfair Display'; font-size: 2.5rem;">Nuestras Amenidades</h2>
    <div class="grid-cards">
        <div class="card-waye">
            <h3>Habitaciones</h3>
            <p>Diseño contemporáneo inspirado en materiales de la región.</p>
        </div>
        <div class="card-waye">
            <h3>Gastronomía</h3>
            <p>Cocina de autor que honra los ingredientes locales.</p>
        </div>
        <div class="card-waye">
            <h3>Rooftop</h3>
            <p>Vistas inigualables de San Servacio y el atardecer vallisoletano.</p>
        </div>
        <div class="card-waye">
            <h3>Ubicación</h3>
            <p>En el corazón de la Calzada de los Frailes.</p>
        </div>
    </div>
</main>

<footer>
    <p>&copy; <?php echo date("Y"); ?> <?php echo $nombre_hotel; ?>. Valladolid, Yucatán, México.</p>
</footer>

</body>
</html>
