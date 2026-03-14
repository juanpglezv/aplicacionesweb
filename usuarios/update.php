<?php
//Verifica que la solicitud se haga por POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../login.php");
    exit();
}
// Tomamos los datos por metodo post
$usuario_id = $_POST['id'];
$nombre = $_POST['nombre'];
$correo = $_POST['correo'];
$password = $_POST['password'];
// Cambiar esta línea en update.php:
$es_admin = isset($_POST['es_admin']) ? 1 : 0; // Ahora busca 'es_admin'

// Validamos que los campos no estén vacíos
if (empty($nombre) || empty($correo) || empty($usuario_id)) {
    header("Location: editar.php?id=" . $usuario_id . "&error=Todos los campos son obligatorios.");
    exit();
}

// Conexión a la base de datos
include '../lib/conn.php';

// 🔥 PRIMERO: Obtener la contraseña actual del usuario
$stmt_check = $conexion->prepare("SELECT password FROM usuarios WHERE id = ?");
$stmt_check->bind_param("i", $usuario_id);
$stmt_check->execute();
$result_check = $stmt_check->get_result();
$usuario_actual = $result_check->fetch_assoc();
$password_actual = $usuario_actual['password'];

// 🔥 COMPARAR: Si la contraseña enviada es IGUAL a la actual, no la actualizamos
if ($password === $password_actual) {
    // La contraseña no cambió, actualizar solo nombre, correo y admin
    $stmt = $conexion->prepare("UPDATE usuarios SET nombre = ?, correo = ?, es_admin = ? WHERE id = ?");
    $stmt->bind_param("ssii", $nombre, $correo, $es_admin, $usuario_id);
} else {
    // La contraseña cambió, aplicar hash y actualizar todo
    $hashed_password = md5($password);
    $stmt = $conexion->prepare("UPDATE usuarios SET nombre = ?, correo = ?, password = ?, es_admin = ? WHERE id = ?");
    $stmt->bind_param("sssii", $nombre, $correo, $hashed_password, $es_admin, $usuario_id);
}

// ejecutamos la consulta
if ($stmt->execute()) {
    header("Location: index.php?exito=Usuario actualizado correctamente.");
} else {
    header("Location: editar.php?id=" . $usuario_id . "&error=Error al actualizar el usuario: " . $stmt->error);
}
?>

