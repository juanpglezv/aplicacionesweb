<?php
session_start();
// Verificar si el usuario esta autenticado
if (!isset($_SESSION["usuario"])) {
    header("Location: ../login.php");
    exit();
}
// Obtener ID del usuario desde GET
$usuario_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
// Valida si el ID viene vacio
if ($usuario_id <= 0) {
    header("Location: index.php");
    exit();
}
//Conexion a la base de datos
include("../lib/conn.php");
//Obtener datos del usuario prepared statement
$stmt = $conexion->prepare("SELECT * FROM usuarios WHERE id = ?");
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();
$usuario = $result->fetch_assoc();
// valida si el usuario a editar existe y si no te dirige a el listado
if (!$usuario) {
    header("Location: index.php");
    exit();
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
        <form action="update.php" method="POST">

            <input type="hidden" name="id" value="<?php echo $usuario['id']; ?>">

            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($usuario['nombre']); ?>" required>

            <label for="correo">Correo:</label>
            <input type="email" id="correo" name="correo" value="<?php echo htmlspecialchars($usuario['correo']); ?>" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" value="<?php echo htmlspecialchars($usuario['password']); ?>" required>

            <label for="es_admin">Administrador:</label>
            <input type="checkbox" id="es_admin" name="es_admin" value="1" <?php echo ($usuario['es_admin'] == 1) ? 'checked' : ''; ?>>

            <div style="display: flex; gap: 10px; margin-top: 20px;">
                <button type="submit" 
                        style="flex:1; padding: 14px; font-size: 16px; font-weight:bold; 
                               background-color:#000; color:#fff; border:none; cursor:pointer;">
                    Guardar Cambios
                </button>
                <button type="button" 
                        onclick="window.location.href='index.php';"
                        style="flex:1; padding: 14px; font-size: 16px; font-weight:bold; 
                               background-color:#777; color:#fff; border:none; cursor:pointer;">
                    Cancelar
                </button>
            </div>
        </form>
    </div>
</body>
</html>


