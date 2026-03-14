<?php
session_start();

// Verificar si el usuario inició sesión
if (!isset($_SESSION["usuario"])) {
    header("Location: ../login.php");
    exit;
}

// Solo procesar por POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: nuevo.php");
    exit;
}

// Incluir conexión a la base de datos
include '../lib/conn.php';

// Obtener datos del formulario
$nombre = trim($_POST['nombre'] ?? '');
$email = trim($_POST['correo'] ?? '');
$password = $_POST['password'] ?? '';
$confirm_password = $_POST['confirmar'] ?? '';
$es_admin = isset($_POST['admin']) ? 1 : 0;

// Guardar datos en sesión por si hay error (para mantener el formulario lleno)
$_SESSION['old_nombre'] = $nombre;
$_SESSION['old_correo'] = $email;
$_SESSION['old_admin'] = $es_admin;

// Validaciones
if (empty($nombre) || empty($email) || empty($password) || empty($confirm_password)) {
    $_SESSION['error'] = "Todos los campos son obligatorios.";
    header("Location: nuevo.php");
    exit;
}

if ($password !== $confirm_password) {
    $_SESSION['error'] = "Las contraseñas no coinciden.";
    header("Location: nuevo.php");
    exit;
}

// Validar formato de email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error'] = "El correo electrónico no es válido.";
    header("Location: nuevo.php");
    exit;
}

// Validar longitud de contraseña (opcional)
if (strlen($password) < 4) {
    $_SESSION['error'] = "La contraseña debe tener al menos 4 caracteres.";
    header("Location: nuevo.php");
    exit;
}

// Hashear contraseña con md5 (aunque no es el método más seguro, mantengo el que usabas)
$hashed_password = md5($password);

// Verificar si el correo ya existe
$check = $conexion->prepare("SELECT id FROM usuarios WHERE correo = ?");
$check->bind_param("s", $email);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
    $_SESSION['error'] = "El correo electrónico ya está registrado.";
    $check->close();
    header("Location: nuevo.php");
    exit;
}
$check->close();

// Insertar usuario en la base de datos
$stmt = $conexion->prepare("INSERT INTO usuarios (nombre, correo, password, es_admin) VALUES (?, ?, ?, ?)");
$stmt->bind_param("sssi", $nombre, $email, $hashed_password, $es_admin);

if ($stmt->execute()) {
    $_SESSION['exito'] = "Usuario creado correctamente.";
    // Limpiar datos guardados del formulario
    unset($_SESSION['old_nombre']);
    unset($_SESSION['old_correo']);
    unset($_SESSION['old_admin']);
} else {
    $_SESSION['error'] = "Error al crear el usuario: " . $stmt->error;
}

$stmt->close();
$conexion->close();

// Redireccionar al formulario
header("Location: nuevo.php");
exit;
?>

