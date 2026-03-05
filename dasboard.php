<?php
session_start();

// Verificar si el usuario inició sesión
 if (!isset($_SESSION["usuario"])) {
    header("Location: ../login.php");
     exit();
 }

 $nombre_usuario = $_SESSION["usuario"];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Mi Empresa</title>
    <style>
        /* Estilos generales */
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            background-color: #f0f2f5;
        }

        /* Header */
        header {
            background: linear-gradient(90deg, #004080, #0066cc);
            color: white;
            padding: 20px;
            text-align: center;
            width: 100%;
            position: fixed;
            top: 0;
            left: 0;
            height: 60px; /* 🔹 Línea nueva: altura fija */
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            z-index: 1000;
        }

        /* Menú lateral */
        nav {
            background: #1c1c1c;
            width: 220px;
            height: 100vh;
            padding-top: 80px; /* 🔹 Línea ajustada: coincide con altura del header */
            position: fixed;
            left: 0;
            top: 0;
            box-shadow: 2px 0 5px rgba(0,0,0,0.2);
        }
        nav ul {
            list-style: none;
            padding: 0;
        }
        nav ul li {
            padding: 15px;
            border-bottom: 1px solid #333;
        }
        nav ul li a {
            text-decoration: none;
            color: #ddd;
            display: block;
            transition: background 0.3s, color 0.3s;
        }
        nav ul li a:hover {
            background: #0066cc;
            color: #fff;
            border-radius: 5px;
            padding-left: 10px;
        }

        /* Contenido principal */
        main {
            margin-left: 240px;   /* 🔹 Línea ajustada: más espacio para menú */
            margin-top: 100px;    /* 🔹 Línea ajustada: más espacio para header */
            padding: 30px;
            flex: 1;
            min-height: calc(100vh - 140px); /* 🔹 Línea nueva: evita recorte con footer */
            box-sizing: border-box;
        }
        main h2 {
            color: #004080;
        }
        main p {
            color: #333;
        }

        /* Footer */
        footer {
            background: #004080;
            color: white;
            text-align: center;
            padding: 15px;
            position: fixed;
            bottom: 0;
            width: 100%;
            box-shadow: 0 -2px 5px rgba(0,0,0,0.2);
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <h1>Mi Empresa S.A. - Panel Administrativo</h1>
    </header>

    <!-- Menú lateral -->
    <nav>
        <ul>
            <li><a href="#">🏠 Inicio</a></li>
            <li><a href="#">👥 Clientes</a></li>
            <li><a href="#">👤 Usuarios</a></li>
            <li><a href="#">📊 Reportes</a></li>
            <li><a href="#">⚙️ Configuración</a></li>
        </ul>
    </nav>

    <!-- Contenido principal -->
    <main>
        <h2>Bienvenido <?php echo $_SESSION["usuario"]; ?> 👋</h2>
        <p>Este es tu panel principal. Aquí podrás gestionar clientes, usuarios y visualizar reportes.</p>
    </main>

    <!-- Footer -->
    <footer>
        <p>&copy; 2026 Mi Empresa S.A. - Todos los derechos reservados</p>
    </footer>
</body>
</html>

