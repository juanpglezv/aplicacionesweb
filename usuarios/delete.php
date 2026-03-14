<?php
session_start();

// Validamos que la solicitud sea metodo POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit();
}

// Tomamos los valores que vienen por metodo POST
$id = $_POST['id'] ?? '';

// Validamos si el valor no viene vacio y es numérico
if (empty($id) || !is_numeric($id)) {
    $_SESSION['mensaje'] = "Error: ID de usuario no válido.";
    header('Location: index.php');
    exit();
}

// Conexion a la base de datos
$conexion = new mysqli("localhost", "root", "", "mipagina");

// Verificar conexión
if ($conexion->connect_error) {
    $_SESSION['mensaje'] = "Error de conexión: " . $conexion->connect_error;
    header('Location: index.php');
    exit();
}

// Eliminar el registro usando prepared statement
$stmt = $conexion->prepare("DELETE FROM usuarios WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    $_SESSION['mensaje'] = "Usuario eliminado correctamente.";
} else {
    $_SESSION['mensaje'] = "Error al eliminar el usuario: " . $conexion->error;
}

$stmt->close();
$conexion->close();

// Redireccionar
header('Location: index.php');
exit();
?>