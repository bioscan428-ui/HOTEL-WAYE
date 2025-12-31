<?php
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

$usuario_nombre = $_SESSION['nombre'] ?? $_SESSION['usuario'];
?>
<style>
/* ===== HEADER ===== */
header.waye-header{
    height:80px;
    background:#1a1a1a;
    display:flex;
    align-items:center;
    padding:0 40px;
    position:fixed;
    top:0;
    width:100%;
    z-index:1000;
    justify-content:space-between;
    box-sizing:border-box;
}

.header-left{
    display:flex;
    align-items:center;
}

.header-left img{
    height:50px;
    cursor:pointer;
}

.header-right{
    display:flex;
    align-items:center;
    gap:15px;
    position:relative;
    z-index:1100;
}

.usuario-nombre{
    color:#F9F3D3;
    font-weight:500;
    white-space:nowrap;
    margin-right:10px;
}

/* ===== HAMBURGER ===== */
.hamburger{
    width:26px;
    height:18px;
    cursor:pointer;
    display:flex !important;
    flex-direction:column;
    justify-content:space-between;
    align-items:center;
    opacity:1 !important;
    visibility:visible !important;
    pointer-events:auto !important;
    position:relative;
    z-index:1100;
}

.hamburger span{
    display:block !important;
    width:100%;
    height:3px;
    background:#F9F3D3;
    border-radius:2px;
    opacity:1 !important;
    visibility:visible !important;
    transition:0.3s ease;
}

/* Animación del botón hamburguesa al abrir menú */
.hamburger.active span:nth-child(1){
    transform:translateY(7.5px) rotate(45deg);
}

.hamburger.active span:nth-child(2){
    opacity:0;
}

.hamburger.active span:nth-child(3){
    transform:translateY(-7.5px) rotate(-45deg);
}

/* ===== SIDEBAR ===== */
.sidebar{
    position:fixed;
    top:0;
    right:-260px;
    width:260px;
    height:100%;
    background:#1a1a1a;
    padding-top:80px;
    padding-bottom:80px; /* ← espacio para logout */
    overflow-y:auto;
    transition:0.3s ease;
    z-index:999;
}


.sidebar.active{
    right:0;
}

.sidebar a{
    display:block;
    padding:15px 25px;
    color:#F9F3D3;
    text-decoration:none;
    font-weight:500;
    border-bottom:1px solid rgba(255,255,255,0.05);
}

.sidebar a:hover{
    background:#2a2a2a;
}

.sidebar .logout{
    position:sticky;
    bottom:0;
    margin-top:40px;
    padding:15px 0;
    background:#1a1a1a;
    text-align:center;
    color:#d4a373;
}


/* ===== SUBMENÚS ===== */
.menu-item > a{
    cursor:pointer;
}

.submenu{
    display:none;
    background:#111;
}

.submenu a{
    padding:12px 40px;
    font-size:14px;
    color:#d4cdb5;
    border-bottom:1px solid rgba(255,255,255,0.04);
}

.submenu a:hover{
    background:#222;
}

/* ===== HAMBURGER INTERNO SIDEBAR ===== */
.sidebar-hamburger{
    display:none;
}
.sidebar-hamburger span{
    display:block;
    width:22px;
    height:2.5px;
    background:#F9F3D3;
    border-radius:2px;
}


/* ===== MOBILE ===== */
@media(max-width:768px){

    /* HEADER CONTENEDOR */
    header.waye-header{
        flex-direction:column;
        align-items:center;
        justify-content:flex-start;
        height:auto;
        padding:15px 20px 20px;
    }

    /* LOGO CENTRADO */
    .header-left{
        order:2;
        margin-top:10px;
    }

    .header-left img{
        height:40px;
    }

    /* NOMBRE DE USUARIO DEBAJO DEL LOGO */
    .header-right{
        order:3;
        width:100%;
        flex-direction:column;
        align-items:center;
        gap:6px;
        margin-top:5px;
        position:static; /* ← CLAVE */
    }


    .usuario-nombre{
        font-size:14px;
        margin:0;
    }

    /* HAMBURGER ESQUINA SUPERIOR DERECHA */
    .hamburger{
        position:fixed;       /* ← YA NO depende del header */
        top:15px;
        right:20px;
        width:22px;
        height:16px;
        z-index:1600;         /* ← MISMA CAPA QUE SIDEBAR */
    }

    /* HAMBURGER VISIBLE SOBRE SIDEBAR CUANDO ESTÁ ABIERTA */
    .hamburger.active{
        right:20px;           /* alineado con la sidebar */
        top:15px;
        z-index:1700;         /* por encima de sidebar */
    }


    .hamburger span{
        height:2.5px;
    }

    /* SIDEBAR POR ENCIMA DEL HEADER (SOLO MÓVIL) */
    .sidebar{
        z-index:1500;
    }
    /* HAMBURGER DENTRO DE SIDEBAR (MÓVIL) */
    .sidebar-hamburger{
        display:flex;
        flex-direction:column;
        justify-content:space-between;
        position:fixed;
        top:15px;
        right:20px;
        width:22px;
        height:16px;
        z-index:1800;
        cursor:pointer;
    }

    /* Ocultar hamburger del header cuando sidebar está activa */
    .sidebar.active ~ header .hamburger{
        display:none;
    }


}
</style>

<header class="waye-header">
    <div class="header-left">
        <a href="dashboard.php">
            <img src="imagenes/waye.png" alt="Hotel Waye">
        </a>
    </div>

    <div class="header-right">
        <div class="usuario-nombre">
            <?php echo htmlspecialchars($usuario_nombre); ?>
        </div>
        
        <div class="hamburger" onclick="toggleMenu()">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
</header>

<div class="sidebar" id="sidebar">
    <!-- HAMBURGER DENTRO DE SIDEBAR (SOLO MÓVIL) -->
    <div class="sidebar-hamburger" onclick="toggleMenu()">
        <span></span>
        <span></span>
        <span></span>
    </div>


    <!-- CLIENTES -->
    <div class="menu-item">
        <a href="javascript:void(0)" onclick="toggleSubmenu('clientes-sub')">
            Clientes
        </a>
        <div class="submenu" id="clientes-sub">
            <a href="registro_cliente.php">Nuevo cliente</a>
            <a href="ver_clientes.php">Ver clientes</a>
        </div>
    </div>

    <!-- RESERVAS -->
    <a href="#">Reservas</a>

    <!-- HABITACIONES -->
    <a href="#">Habitaciones</a>

    <!-- PRECIOS -->
    <a href="#">Precios</a>

    <!-- Admin Financiera -->
    <div class="menu-item">
        <a href="javascript:void(0)" onclick="toggleSubmenu('Admin_financiera-sub')">
            Admin. Financiera
        </a>
        <div class="submenu" id="Admin_financiera-sub">
            <a href="registro_egreso.php">Registrar Egreso</a>
            <a href="ver_egresos.php">Ver Egresos</a>
            <a href="registro_conceptos_egresos.php">Registro Conceptos Egresos</a>
        </div>
    </div>

    <!-- USUARIOS -->
    <div class="menu-item">
        <a href="javascript:void(0)" onclick="toggleSubmenu('usuarios-sub')">
            Usuarios
        </a>
        <div class="submenu" id="usuarios-sub">
            <a href="registro_empleados.php">Registrar usuario</a> <a href="ver_empleados.php">Ver usuarios</a>
        </div>
    </div>

    <!-- LOGOUT -->
    <a href="logout.php" class="logout">Cerrar sesión</a>
</div>



<script>
function toggleMenu(e){
    const sidebar = document.getElementById('sidebar');
    const hamburger = document.querySelector('.hamburger');
    sidebar.classList.toggle('active');
    hamburger.classList.toggle('active');
}

function toggleSubmenu(id){
    const submenu = document.getElementById(id);
    // Cerramos los demás submenús abiertos
    document.querySelectorAll('.submenu').forEach(s => {
        if(s.id !== id) s.style.display = 'none';
    });
    
    // Cambiamos entre block y none
    const isVisible = window.getComputedStyle(submenu).display === 'block';
    submenu.style.display = isVisible ? 'none' : 'block';
}

// Cerrar sidebar al hacer clic fuera
document.addEventListener('click', function(event) {
    const sidebar = document.getElementById('sidebar');
    const hamburger = document.querySelector('.hamburger');
    
    // Si la sidebar no está activa, no hacemos nada
    if (!sidebar.classList.contains('active')) return;

    // Si el clic fue en un enlace, dejamos que el navegador actúe normal
    if (event.target.closest('a')) return;

    // Si el clic fue fuera de la sidebar y del botón hamburguesa, cerramos
    if (!sidebar.contains(event.target) && !hamburger.contains(event.target)) {
        sidebar.classList.remove('active');
        hamburger.classList.remove('active');
    }
});
</script>
