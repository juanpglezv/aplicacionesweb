<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' ){
include '../lib/conn.php';
    $nombre = $_POST['nombre'];
    $email = $_POST['correo'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirmar'];
    $es_admin = isset($_POST['admin']) ? 1 : 0;

    // echo "Nombre: " . $nombre . "<br>";    
    // Validar campos vacios y contraseñas coincidan
    if (empty($nombre) || empty($email) || empty($password) || empty ($confirm_password)) {
        $error = "Todos los campos son obligatorios.";
    } elseif ($password !== $confirm_password) {
        $error = "Las contraseñas no coinciden.";
    } else {
        // Insertar usuario en la base de datos
        $stmt = $conexion->prepare("INSERT INTO usuarios (nombre, correo, password, es_admin) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $nombre, $email, MD5($password), $es_admin);

        if ($stmt->execute()) {
            $exito = "Usuario creado exitosamente.";
        } else {
            $error = "Error al crear el usuario: " . $stmt->error;
        }

        $stmt->close();
    }
    // redireccionar a la pagina con el mensaje de error o exito
    header("Location: nuevo.php?error=" . urlencode($error) . "&exito=" . urlencode($exito));
    exict();

}
?>