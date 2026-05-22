<?php
// dasboard.php
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

$userName = $_SESSION['user_name'] ?? 'Usuario';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard — EPIAS</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;900&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #f0f4f8;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* ── Header ── */
        .header {
            background: linear-gradient(135deg, #1a3a5c 0%, #217a8c 100%);
            color: white;
            padding: 12px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }

        .header h1 { font-size: 20px; font-weight: 900; letter-spacing: 1px; }

        .user-menu { display: flex; align-items: center; gap: 16px; }

        .user-info span { font-size: 14px; font-weight: 600; color: #9dd9ff; }

        .btn-sitio {
            background: rgba(255,255,255,0.15);
            color: white;
            padding: 7px 14px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            transition: background 0.2s;
        }
        .btn-sitio:hover { background: rgba(255,255,255,0.25); }

        .logout-btn {
            background: #e74c3c;
            color: white;
            padding: 7px 14px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            transition: background 0.2s;
        }
        .logout-btn:hover { background: #c0392b; }

        /* ── Layout ── */
        .container { display: flex; flex: 1; }

        /* ── Sidebar ── */
        .sidebar {
            width: 230px;
            background: #1a3a5c;
            padding: 24px 0;
            box-shadow: 2px 0 8px rgba(0,0,0,0.15);
        }

        .sidebar ul { list-style: none; }

        .sidebar a {
            display: block;
            color: rgba(255,255,255,0.75);
            text-decoration: none;
            padding: 14px 24px;
            font-size: 14px;
            font-weight: 600;
            border-left: 4px solid transparent;
            transition: all 0.25s;
        }

        .sidebar a:hover, .sidebar a.active {
            background: rgba(56,143,197,0.2);
            color: #9dd9ff;
            border-left-color: #388fc5;
            padding-left: 28px;
        }

        /* ── Contenido ── */
        .main-content { flex: 1; padding: 32px; }

        /* ── Cards de bienvenida ── */
        .welcome-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 28px;
        }

        .welcome-card {
            background: white;
            border-radius: 12px;
            padding: 24px;
            text-align: center;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
            border-top: 4px solid #388fc5;
            text-decoration: none;
            color: #1a3a5c;
            transition: transform 0.2s, box-shadow 0.2s;
            cursor: pointer;
        }

        .welcome-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(56,143,197,0.15);
        }

        .welcome-card .icon { font-size: 40px; margin-bottom: 12px; }
        .welcome-card h3 { font-size: 16px; font-weight: 700; margin-bottom: 6px; }
        .welcome-card p { font-size: 12px; color: #7aa79b; }

        .welcome-card.clientes { border-top-color: #388fc5; }
        .welcome-card.usuarios { border-top-color: #217a8c; }
        .welcome-card.productos { border-top-color: #7aa79b; }

        .page-title {
            font-size: 22px;
            font-weight: 700;
            color: #1a3a5c;
            border-bottom: 3px solid #388fc5;
            padding-bottom: 12px;
            margin-bottom: 8px;
        }

        .page-subtitle { color: #7aa79b; font-size: 13px; }

        /* ── Footer ── */
        .footer {
            background: #1a3a5c;
            color: rgba(255,255,255,0.7);
            text-align: center;
            padding: 16px;
            font-size: 13px;
        }
        .footer a { color: #9dd9ff; text-decoration: none; }
        .footer a:hover { text-decoration: underline; }
    </style>
</head>
<body>

    <header class="header">
        <div style="display:flex;align-items:center;gap:14px;">
            <img src="EPIAS.jpg" alt="EPIAS" style="height:40px;width:40px;border-radius:6px;object-fit:cover;border:2px solid #388fc5;">
            <div>
                <span style="font-size:16px;font-weight:900;color:white;display:block;line-height:1.1;">EPIAS</span>
                <span style="font-size:10px;color:#9dd9ff;display:block;">Panel de Administración</span>
            </div>
        </div>
        <div class="user-menu">
            <div class="user-info"><span>👋 <?php echo htmlspecialchars($userName); ?></span></div>
            <a href="landinpage.html" class="btn-sitio">🌐 Sitio Web</a>
            <a href="logout.php" class="logout-btn">Cerrar Sesión</a>
        </div>
    </header>

    <div class="container">
        <div class="sidebar">
            <ul>
                <li><a href="dasboard.php" class="active">🏠 Dashboard</a></li>
                <li><a href="clientes.html">👥 Clientes</a></li>
                <li><a href="usuarios.html">👤 Usuarios</a></li>
                <li><a href="productos.html">📦 Productos</a></li>
            </ul>
        </div>

        <main class="main-content">
            <h1 class="page-title">Panel de Control</h1>
            <p class="page-subtitle">Selecciona un módulo para administrar</p>

            <div class="welcome-grid">
                <a href="clientes.html" class="welcome-card clientes">
                    <div class="icon">👥</div>
                    <h3>Clientes</h3>
                    <p>Gestionar clientes registrados</p>
                </a>
                <a href="usuarios.html" class="welcome-card usuarios">
                    <div class="icon">👤</div>
                    <h3>Usuarios</h3>
                    <p>Administrar accesos al sistema</p>
                </a>
                <a href="productos.html" class="welcome-card productos">
                    <div class="icon">📦</div>
                    <h3>Productos</h3>
                    <p>Inventario y catálogo (Fetch API)</p>
                </a>
            </div>
        </main>
    </div>

    <footer class="footer">
        <p>&copy; 2026 EPIAS — Ingeniería Ambiental y Sanitaria | <a href="landinpage.html">Sitio Web</a></p>
    </footer>

</body>
</html>