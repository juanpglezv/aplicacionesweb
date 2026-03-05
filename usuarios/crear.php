<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' ){
    include '../lib/conn.php';

    $nombre = $_POST['nombre'];
    $email = $_POST['correo'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirmar'];
    $es_admin = isset($_POST['admin']) ? 1 : 0;

    // Validar campos vacíos y contraseñas coincidan
    if (empty($nombre) || empty($email) || empty($password) || empty($confirm_password)) {
        $error = "Todos los campos son obligatorios.";
    } elseif ($password !== $confirm_password) {
        $error = "Las contraseñas no coinciden.";
    } else {
        $hashed_password = md5($password);

        // Verificar si el correo ya existe
        $check = $conexion->prepare("SELECT id FROM usuarios WHERE correo = ?");
        $check->bind_param("s", $email);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            $error = "Usuario ya registrado.";
        } else {
            // Insertar usuario en la base de datos
            $stmt = $conexion->prepare("INSERT INTO usuarios (nombre, correo, password, es_admin) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("sssi", $nombre, $email, $hashed_password, $es_admin);

            if ($stmt->execute()) {
                $exito = "Conexión exitosa. Usuario creado.";
            } else {
                $error = "Error al crear el usuario: " . $stmt->error;
            }

            $stmt->close();
        }
        $check->close();
    }

    // Mostrar directamente en la misma página
    if (!empty($exito)) {
        echo "<p>" . $exito . "</p>";
        echo "<p>Nombre: " . htmlspecialchars($nombre) . "</p>";
        echo "<p>Correo: " . htmlspecialchars($email) . "</p>";
        echo "<p>Contraseña: " . htmlspecialchars($password) . "</p>";
    }
    if (!empty($error)) {
        echo "<p>" . $error . "</p>";
        echo "<p>Nombre: " . htmlspecialchars($nombre) . "</p>";
        echo "<p>Correo: " . htmlspecialchars($email) . "</p>";
        echo "<p>Contraseña: " . htmlspecialchars($password) . "</p>";
    }
}
?>
