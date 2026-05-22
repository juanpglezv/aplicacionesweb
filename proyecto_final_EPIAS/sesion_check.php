<?php
// sesion_check.php — Devuelve si el usuario está logueado (lo llama landinpage.html con fetch)
session_start();
header('Content-Type: application/json');

if (isset($_SESSION['usuario'])) {
    echo json_encode([
        'logueado' => true,
        'nombre'   => $_SESSION['user_name'] ?? $_SESSION['usuario'],
        'correo'   => $_SESSION['usuario']
    ]);
} else {
    echo json_encode(['logueado' => false]);
}
?>