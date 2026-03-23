<?php
//Verifica que la solicitud se haga por POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../login.php");
    exit();
}
// Tomamos los datos por metodo post
$cliente_id = $_POST['id'];
$nombre = $_POST['nombre'];
$domicilio = $_POST['domicilio'];
$giro = $_POST['giro'];
$razon_social = $_POST['razon_social'];

// Cambiar esta línea en update.php:
$giro = isset($_POST['giro']) ? 1 : 0; // Ahora busca 'giro'

// Validamos que los campos no estén vacíos
if (empty($nombre) || empty($domicilio) ||empty($giro) ||empty($razon_social) ||empty($cliente_id)) {
    header("Location: editar.php?id=" . $cliente_id . "&error=Todos los campos son obligatorios.");
    exit();
}

// Conexión a la base de datos
include '../lib/conn.php';


// La contraseña no cambió, actualizar solo nombre, domicilio y admin
$stmt = $conexion->prepare("UPDATE clientes SET nombre = ?, domicilio = ?, giro = ?, razon_social = ? WHERE id = ?");
$stmt->bind_param("ssssi", $nombre, $domicilio, $giro, $razon_social, $cliente_id);


// ejecutamos la consulta
if ($stmt->execute()) {
    header("Location: index.php?exito=Usuario actualizado correctamente.");
} else {
    header("Location: editar.php?id=" . $cliente_id . "&error=Error al actualizar el usuario: " . $stmt->error);
}
?>

