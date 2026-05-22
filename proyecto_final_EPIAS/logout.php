<?php
// logout.php — Cierra la sesión y regresa al inicio
session_start();
session_unset();
session_destroy();

header('Location: index.html');
exit;
?>