<?php
// verificacion.php
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php');
    exit;
}

require_once 'conexion.php';

$correo   = trim($_POST['email']    ?? '');
$password = trim($_POST['password'] ?? '');

if (empty($correo) || empty($password)) {
    header('Location: login.php?error=campos_vacios');
    exit;
}

$stmt = $pdo->prepare('SELECT * FROM usuarios WHERE correo = ? LIMIT 1');
$stmt->execute([$correo]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

$passwordOk = false;
if ($usuario) {
    $passDB = $usuario['password'];
    // Soporta contraseñas encriptadas con password_hash Y también texto plano (legacy)
    if (str_starts_with($passDB, '$2y$')) {
        $passwordOk = password_verify($password, $passDB);
    } else {
        $passwordOk = ($password === $passDB);
    }
}

if ($passwordOk) {
    $_SESSION['usuario']   = $usuario['correo'];
    $_SESSION['user_name'] = $usuario['nombre'] ?? $usuario['correo'];
    $_SESSION['user_id']   = $usuario['id'];

    // ✅ CORRECCIÓN: redirige al dashboard independiente, NO a landinpage
    header('Location: dasboard.php');
    exit;
} else {
    header('Location: login.php?error=credenciales_invalidas');
    exit;
}
?>