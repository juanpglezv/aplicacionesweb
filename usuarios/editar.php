<?php
// Conexión a la base de datos (ajusta según tu configuración)
$conexion = new mysqli("localhost", "root", "", "mipagina");

// Verificar conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Obtener ID del usuario desde GET
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    $sql = "SELECT * FROM usuarios WHERE id = $id";
    $resultado = $conexion->query($sql);

    if ($resultado->num_rows > 0) {
        $usuario = $resultado->fetch_assoc();
    } else {
        die("Usuario no encontrado.");
    }
} else {
    die("ID inválido.");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuario</title>
    <style>
        body {
            background-color: #fff;
            font-family: Arial, sans-serif;
            color: #000;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .form-container {
            border: 2px solid #000;
            padding: 30px;
            width: 400px;
            box-shadow: 4px 4px 10px rgba(0,0,0,0.2);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 1px solid #000;
            padding-bottom: 10px;
        }
        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
        }
        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #000;
            margin-top: 5px;
        }
        input[type="checkbox"] {
            margin-top: 10px;
        }
        button {
            margin-top: 20px;
            width: 100%;
            padding: 10px;
            background-color: #000;
            color: #fff;
            border: none;
            cursor: pointer;
            font-weight: bold;
        }
        button:hover {
            background-color: #333;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Editar Usuario</h2>
        <form action="actualizar.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $usuario['id']; ?>">

            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($usuario['nombre']); ?>" required>

            <label for="correo">Correo:</label>
            <input type="email" id="correo" name="correo" value="<?php echo htmlspecialchars($usuario['correo']); ?>" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" value="<?php echo htmlspecialchars($usuario['password']); ?>" required>

            <label for="es_admin">Administrador:</label>
            <input type="checkbox" id="es_admin" name="es_admin" value="1" <?php echo ($usuario['es_admin'] == 1) ? 'checked' : ''; ?>>

            <button type="submit">Actualizar Usuario</button>
        </form>
    </div>
</body>
</html>
