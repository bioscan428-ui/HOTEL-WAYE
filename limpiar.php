<?php
session_start();
session_destroy();
echo "Sesión borrada. <a href='login.php'>Ir al login</a>";
?>