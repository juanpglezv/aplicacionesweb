<?php
$userName = $_SESSION['cliente_name'] ?? 'Clientes';

session_start();
// Verificar si el usuario está autenticado
if (!isset($_SESSION["usuario"])) {
    header("Location: ../login.php");
    exit();
}

// Obtener ID del usuario desde GET
$cliente_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Validar si el ID viene vacío
if ($cliente_id <= 0) {
    header("Location: index.php");
    exit();
}

// Conexión a la base de datos
include("../lib/conn.php");

// Obtener datos del usuario con prepared statement
$stmt = $conexion->prepare("SELECT * FROM clientes WHERE id = ?");
$stmt->bind_param("i", $cliente_id);
$stmt->execute();
$result = $stmt->get_result();
$cliente = $result->fetch_assoc();

// Validar si el usuario existe
if (!$cliente) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Header */
        .header {
            background-color: #2c3e50;
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .header h1 {
            font-size: 24px;
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-info span {
            font-weight: 500;
        }

        .logout-btn {
            background-color: #e74c3c;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .logout-btn:hover {
            background-color: #c0392b;
        }

        /* Container Principal */
        .container {
            display: flex;
            flex: 1;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background-color: #34495e;
            color: white;
            padding: 20px 0;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
        }

        .sidebar ul {
            list-style: none;
        }

        .sidebar li {
            margin: 0;
        }

        .sidebar a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 15px 20px;
            transition: background-color 0.3s, padding-left 0.3s;
            border-left: 4px solid transparent;
        }

        .sidebar a:hover {
            background-color: #2c3e50;
            border-left-color: #3498db;
            padding-left: 25px;
        }

        .sidebar a.active {
            background-color: #2980b9;
            border-left-color: #3498db;
        }

        /* Contenido Principal */
        .main-content {
            flex: 1;
            padding: 30px;
            background-color: #f5f5f5;
        }

        .content-area {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            min-height: 400px;
        }

        .content-area h2 {
            color: #2c3e50;
            margin-bottom: 20px;
            border-bottom: 2px solid #3498db;
            padding-bottom: 10px;
        }

        /* Footer */
        .footer {
            background-color: #2c3e50;
            color: white;
            text-align: center;
            padding: 20px;
            margin-top: auto;
            box-shadow: 0 -2px 5px rgba(0,0,0,0.1);
        }

        .footer p {
            margin: 0;
            font-size: 14px;
        }

        .footer a {
            color: #3498db;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
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
        input[type="text"], input[type="email"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #000;
            margin-top: 5px;
            background-color: #f9f9f9;
        }
        input[readonly], input[disabled] {
            color: #555;
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
    <!-- Header -->
     <?php 
     include ('../templates/header.php'); 
     ?>

    <!-- Container Principal -->
    <div class="container">
        <!-- Sidebar -->
             <?php 
             include ('../templates/sidebar.php'); 
             ?>

        <!-- Contenido Principal -->
        <main class="main-content">
            <div class="content-area">
                <h2>Detalle del Cliente</h2>
    <input type="hidden" id="id" name="id" 
             value="<?= htmlspecialchars($cliente_id) ?>" required>
             
        <div class="grupo">
            <label for="nombre">Nombre</label>
            <input type="text" value="<?= htmlspecialchars($cliente['nombre']) ?>" required disabled>
        </div>

        <div class="grupo">
            <label for="domicilio">Domicilio</label>
            <input type="text" value="<?= htmlspecialchars($cliente['domicilio']) ?>" required disabled>
        </div>

        <div class="grupo">
            <label for="giro">Giro</label>
            <input type="text" value="<?= htmlspecialchars($cliente['giro']) ?>" required disabled>
        </div>

        <div class="grupo">
            <label for="razon_social">Razón Social</label>
            <input type="text" value="<?= htmlspecialchars($cliente['razon_social']) ?>" required disabled>
        </div>

        <div class="botones">
            <button type="button" class="btn-cancelar" onclick="window.location='index.php'">Regresar</button>
        </div>

            </div>
        </main>
    </div>

    <!-- Footer -->
        <?php 
        include ('../templates/footer.php'); 
        ?>
</body>
</html>