<?php
session_start();
// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    header('Location: ../login.php');
    exit;
}
// Obtener ID del usuario desde GET
$usuario_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
// Valida si el ID viene vacio
if ($usuario_id == 0) {
    header('Location: index.php');
    exit;
}
// Conexión a la base de datos
include('../lib/conn.php');
// Obtener datos del usuario usando prepared statements
$stmt = $conexion->prepare('SELECT * FROM usuarios WHERE id = ?');
$stmt->bind_param('i', $usuario_id);
$stmt->execute();
$result = $stmt->get_result();
$usuario = $result->fetch_assoc();
// valida si el usuario a editar existe y si no te dirige a el listado
if (!$usuario) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            padding: 20px;
        }
        .contenedor {
            max-width: 500px;
            margin: 0 auto;
            background-color: white;
            border: 2px solid black;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 28px;
            color: black;
            border-bottom: 2px solid black;
            padding-bottom: 15px;
        }
        .mensaje {
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 4px;
            border-left: 4px solid;
        }
        .mensaje.exito {
            background-color: #d4edda;
            color: #155724;
            border-left-color: #28a745;
        }
        .mensaje.error {
            background-color: #f8d7da;
            color: #721c24;
            border-left-color: #dc3545;
        }
        .grupo {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: black;
            font-size: 14px;
        }
        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            border: 1px solid black;
            border-radius: 4px;
            font-size: 14px;
            transition: border-color 0.3s;
        }
        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: black;
            box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.1);
        }
        .checkbox-grupo {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        input[type="checkbox"] {
            width: 20px;
            height: 20px;
            cursor: pointer;
            accent-color: black;
        }
        .checkbox-grupo label {
            margin-bottom: 0;
            cursor: pointer;
        }
        .botones {
            display: flex;
            gap: 10px;
            margin-top: 30px;
        }
        button {
            flex: 1;
            padding: 12px;
            font-size: 16px;
            font-weight: 600;
            border: 2px solid black;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s;
        }
        .btn-guardar {
            background-color: black;
            color: white;
        }
        .btn-guardar:hover {
            background-color: #333;
        }
        .btn-cancelar {
            background-color: white;
            color: black;
        }
        .btn-cancelar:hover {
            background-color: #f0f0f0;
        }
    </style>
</head>
<body>
    <div class="contenedor">
        <h1>Detalle Usuario</h1>

            <input type="hidden" id="id" name="id" 
             value="<?= htmlspecialchars($usuario_id) ?>" required>
             
        <div class="grupo">
            <label for="nombre">Nombre</label>
            <input type="text" value="<?= htmlspecialchars($usuario['nombre']) ?>" required disabled>
        </div>

        <div class="grupo">
            <label for="correo">Correo Electrónico</label>
            <input type="email" value="<?= htmlspecialchars($usuario['correo']) ?>" required disabled>
        </div>

        <div class="grupo checkbox-grupo">
            <input type="checkbox" <?= $usuario['es_admin'] ? 'checked' : '' ?> disabled>
            <label for="es_admin">Es Administrador</label>
        </div>

        <div class="botones">
            <button type="button" class="btn-cancelar" onclick="window.location='index.php'">Regresar</button>
        </div>
    </div>
</body>
</html>