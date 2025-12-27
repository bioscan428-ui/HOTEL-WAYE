<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Configuración de Identidad del Hotel
$nombre_hotel = "Hotel WAYE";
$logo_url = "https://hotelwaye.com/wp-content/uploads/2021/10/logo-waye-white.png"; // URL oficial del logo blanco
$fondo_hero = "https://hotelwaye.com/wp-content/uploads/2022/03/fachada-waye.jpg";
$color_acento = "#d4a373"; // Tono arena/dorado del hotel
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title><?php echo $nombre_hotel; ?> - Valladolid</title>
    <link href = "css/waye.css" rel = "stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet" />
    <style>
        :root{
            --accent: <?php echo $color_acento; ?>
        }
    </style>
</head>
<body>

<header>
    <div class="logo-box">
        <img src="<?php echo $logo_url; ?>" alt="Logo Waye">
    </div>
    
    <div class="titulo-header">WAYE</div>
    
    <a href="https://waye.mx" class="cta-button">RESERVAR</a>

    <nav>
        <a href="login.php" style="color: var(--accent); font-weight: 600;">Acceso Colaboradores</a>
        <a href="#hotel">El Hotel</a>
        <a href="#contacto">Contacto</a>
    </nav>
</header>

<section class="hero">
    <h1>Conecta con tu origen en el corazón de Yucatán</h1>
    <a href="#servicios" class="btn-main">Descubrir Experiencias</a>
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