<aside class="sidebar">
    <nav>
        <ul>
            <li><a href="dasboard.php" <?php echo (basename($_SERVER['PHP_SELF']) == 'dasboard.php') ? 'class="active"' : ''; ?>>
                🏠 Dashboard
            </a></li>
            <li><a href="clientes/index.php" <?php echo (strpos($_SERVER['PHP_SELF'], 'clientes') !== false) ? 'class="active"' : ''; ?>>
                👥 Clientes
            </a></li>
            <li><a href="usuarios/index.php" <?php echo (strpos($_SERVER['PHP_SELF'], 'usuarios') !== false) ? 'class="active"' : ''; ?>>
                👤 Usuarios
            </a></li>
            <li><a href="productos.html" <?php echo (basename($_SERVER['PHP_SELF']) == 'productos.html') ? 'class="active"' : ''; ?>>
                📦 Productos
            </a></li>
        </ul>
    </nav>
</aside>