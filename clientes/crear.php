<?php
// dashboard.php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['clientes'])) {
    header('Location: login.php');
    exit;
}

$userName = $_SESSION['user_name'] ?? 'Cliente';
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
                 <h1> Registro de clientes </h1>

    <form action="guardar.php" method="post">
    <table border="1">
        <tr> 
            <td>Nombre:</td>
            <td><input type="text" name="nombre" id="nombre"></td>
        </tr>
        <tr>
           <td>Domicilio:</td>
            <td><input type="text" name="domicilio" id="domicilio"></td>
        </tr>
        <tr>
           <td>Giro:</td>
            <td><input type="text" name="giro" id="giro"></td>
        </tr>
        <tr>
           <td>Razon socal:</td>
            <td><input type="text" name="razon_social" id="razon_social"></td>
        </tr>
        <tr>
            <td> <colspan="2" style="text-align: center;">
                <input type="submit" value="Guardar cliente">
            </td>
        </tr>
    </table>
    </form>
            </div>
        </main>
    </div>

    <!-- Footer -->
        <?php 
        include ('../templates/footer.php'); 
        ?>
</body>
</html>