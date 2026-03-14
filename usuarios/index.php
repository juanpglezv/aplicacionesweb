<?php
session_start();
// Verificar si el usuario inició sesión
if (!isset($_SESSION["usuario"])) {
    header("Location: ../login.php");
    exit;
}
// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "mipagina");

$sql = "SELECT id, nombre, correo, es_admin FROM usuarios ORDER BY id DESC";
$result = $conexion->query($sql);
$usuarios = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $usuarios[] = $row;
    }
}

$total     = count($usuarios);
$admins    = count(array_filter($usuarios, fn($u) => $u['es_admin'] == 1));
$regulares = $total - $admins;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios | MiPágina</title>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-primary:    #f0f4f8;
            --bg-secondary:  #ffffff;
            --bg-card:       #ffffff;
            --bg-hover:      #f0f4ff;
            --accent-blue:   #3d7eff;
            --accent-cyan:   #0099cc;
            --accent-green:  #00a854;
            --accent-red:    #e53e3e;
            --text-primary:  #1a202c;
            --text-secondary:#4a5568;
            --text-muted:    #a0aec0;
            --border:        #e2e8f0;
            --border-light:  #edf2f7;
        }
        * { margin:0; padding:0; box-sizing:border-box; }
        body {
            font-family:'Sora',sans-serif;
            background:var(--bg-primary);
            color:var(--text-primary);
            min-height:100vh;
        }
        body::before {
            content:''; position:fixed; inset:0;
            background-image:radial-gradient(circle,#c3d0e8 1px,transparent 1px);
            background-size:28px 28px; opacity:0.5;
            pointer-events:none; z-index:0;
        }
        .layout { position:relative; z-index:1; display:flex; flex-direction:column; min-height:100vh; }

        /* ── Header ── */
        .header {
            background:var(--bg-secondary); border-bottom:1px solid var(--border);
            padding:0 2rem; height:64px;
            display:flex; align-items:center; justify-content:space-between;
            position:sticky; top:0; z-index:100;
            box-shadow:0 1px 8px rgba(0,0,0,0.06);
        }
        .header-brand { display:flex; align-items:center; gap:12px; }
        .brand-icon {
            width:36px; height:36px;
            background:linear-gradient(135deg,var(--accent-blue),var(--accent-cyan));
            border-radius:8px; display:flex; align-items:center; justify-content:center; font-size:18px;
        }
        .brand-name { font-size:1rem; font-weight:600; letter-spacing:-0.02em; }
        .header-nav { display:flex; gap:4px; }
        .nav-link {
            padding:6px 14px; border-radius:6px; color:var(--text-secondary);
            text-decoration:none; font-size:0.85rem; font-weight:500; transition:all 0.2s;
        }
        .nav-link:hover { background:var(--bg-hover); color:var(--text-primary); }
        .nav-link.active { background:rgba(61,126,255,0.15); color:var(--accent-blue); }

        /* ── Main ── */
        .main { flex:1; padding:2rem; max-width:1200px; width:100%; margin:0 auto; }

        /* ── Page header ── */
        .page-header {
            display:flex; align-items:flex-start; justify-content:space-between;
            margin-bottom:2rem; animation:fadeDown 0.5s ease both;
        }
        .breadcrumb {
            display:flex; align-items:center; gap:6px;
            font-size:0.78rem; color:var(--text-muted);
            margin-bottom:6px; font-family:'JetBrains Mono',monospace;
        }
        .breadcrumb a { color:var(--text-secondary); text-decoration:none; }
        .breadcrumb a:hover { color:var(--accent-cyan); }
        .page-title-group h1 { font-size:1.75rem; font-weight:700; letter-spacing:-0.03em; line-height:1.2; }
        .page-title-group p  { font-size:0.875rem; color:var(--text-secondary); margin-top:4px; }

        .btn-new {
            display:inline-flex; align-items:center; gap:8px;
            background:linear-gradient(135deg,var(--accent-blue),var(--accent-cyan));
            color:#fff; padding:10px 20px; border-radius:8px;
            text-decoration:none; font-size:0.875rem; font-weight:600;
            transition:all 0.2s; box-shadow:0 0 20px rgba(61,126,255,0.3); white-space:nowrap;
        }
        .btn-new:hover { transform:translateY(-1px); box-shadow:0 4px 28px rgba(61,126,255,0.5); }
        .btn-new svg { width:16px; height:16px; }

        /* ── Stats ── */
        .stats-row {
            display:grid; grid-template-columns:repeat(auto-fit,minmax(160px,1fr));
            gap:1rem; margin-bottom:1.5rem; animation:fadeUp 0.5s 0.1s ease both;
        }
        .stat-card {
            background:var(--bg-card); border:1px solid var(--border);
            border-radius:10px; padding:1rem 1.25rem;
            display:flex; align-items:center; gap:14px;
            box-shadow:0 2px 8px rgba(0,0,0,0.05);
        }
        .stat-icon {
            width:40px; height:40px; border-radius:8px;
            display:flex; align-items:center; justify-content:center;
            font-size:18px; flex-shrink:0;
        }
        .si-blue   { background:rgba(61,126,255,0.15); }
        .si-yellow { background:rgba(255,187,0,0.12); }
        .si-cyan   { background:rgba(0,212,255,0.12); }
        .stat-value { font-size:1.5rem; font-weight:700; line-height:1; }
        .stat-label { font-size:0.75rem; color:var(--text-secondary); margin-top:2px; }

        /* ── Toolbar ── */
        .toolbar {
            background:var(--bg-card); border:1px solid var(--border);
            border-radius:10px 10px 0 0; padding:1rem 1.25rem;
            display:flex; align-items:center; gap:1rem; flex-wrap:wrap;
            animation:fadeUp 0.5s 0.2s ease both;
            box-shadow:0 2px 8px rgba(0,0,0,0.04);
        }
        .search-box { flex:1; min-width:200px; position:relative; }
        .search-box input {
            width:100%; background:var(--bg-secondary); border:1px solid var(--border-light);
            border-radius:7px; padding:8px 12px 8px 36px;
            color:var(--text-primary); font-size:0.875rem;
            font-family:'Sora',sans-serif; transition:border-color 0.2s;
        }
        .search-box input:focus { outline:none; border-color:var(--accent-blue); }
        .search-box input::placeholder { color:var(--text-muted); }
        .search-icon { position:absolute; left:10px; top:50%; transform:translateY(-50%); color:var(--text-muted); }
        .filter-select {
            background:var(--bg-secondary); border:1px solid var(--border-light);
            border-radius:7px; padding:8px 12px; color:var(--text-primary);
            font-size:0.875rem; font-family:'Sora',sans-serif; cursor:pointer;
        }
        .filter-select:focus { outline:none; border-color:var(--accent-blue); }
        .records-count { font-size:0.78rem; color:var(--text-muted); font-family:'JetBrains Mono',monospace; margin-left:auto; }

        /* ── Table ── */
        .table-wrapper {
            background:var(--bg-card); border:1px solid var(--border);
            border-top:none; border-radius:0 0 10px 10px; overflow:hidden;
            animation:fadeUp 0.5s 0.3s ease both;
            box-shadow:0 2px 12px rgba(0,0,0,0.05);
        }
        table { width:100%; border-collapse:collapse; }
        thead { background:#f7faff; border-bottom:1px solid var(--border); }
        th {
            padding:12px 16px; text-align:left;
            font-size:0.72rem; font-weight:600;
            text-transform:uppercase; letter-spacing:0.08em; color:var(--text-secondary);
        }
        th.center, td.center { text-align:center; }
        tbody tr { border-bottom:1px solid var(--border); transition:background 0.15s; }
        tbody tr:last-child { border-bottom:none; }
        tbody tr:hover { background:var(--bg-hover); }
        td { padding:14px 16px; font-size:0.875rem; vertical-align:middle; }

        .user-cell { display:flex; align-items:center; gap:12px; }
        .avatar {
            width:36px; height:36px; border-radius:8px;
            display:flex; align-items:center; justify-content:center;
            font-size:0.8rem; font-weight:700; flex-shrink:0;
        }
        .user-name { font-weight:600; font-size:0.875rem; }
        .user-id   { font-size:0.72rem; color:var(--text-muted); font-family:'JetBrains Mono',monospace; }
        .email-text { color:var(--text-secondary); font-size:0.82rem; }

        .badge {
            display:inline-flex; align-items:center; gap:5px;
            padding:4px 10px; border-radius:20px;
            font-size:0.72rem; font-weight:600; letter-spacing:0.02em;
        }
        .badge-dot { width:6px; height:6px; border-radius:50%; }
        .badge-admin { background:rgba(61,126,255,0.15); color:var(--accent-blue); }
        .badge-admin .badge-dot { background:var(--accent-blue); }
        .badge-user  { background:rgba(138,180,248,0.1); color:#8ab4f8; }
        .badge-user .badge-dot  { background:#8ab4f8; }

        /* Action buttons */
        .actions { display:flex; align-items:center; gap:6px; justify-content:center; }
        .btn-action {
            width:32px; height:32px; border-radius:7px;
            border:1px solid var(--border-light); background:var(--bg-secondary);
            color:var(--text-secondary); cursor:pointer;
            display:flex; align-items:center; justify-content:center;
            transition:all 0.2s; text-decoration:none; font-size:14px;
        }
        .btn-action:hover { transform:translateY(-1px); }
        .btn-view:hover   { background:rgba(0,212,255,0.12); border-color:var(--accent-cyan); color:var(--accent-cyan); }
        .btn-edit:hover   { background:rgba(61,126,255,0.15); border-color:var(--accent-blue); color:var(--accent-blue); }
        .btn-delete:hover { background:rgba(255,69,96,0.12);  border-color:var(--accent-red);  color:var(--accent-red); }

        /* Empty states */
        .empty-state { text-align:center; padding:4rem 2rem; color:var(--text-muted); }
        .empty-state .icon { font-size:3rem; margin-bottom:1rem; opacity:0.5; }
        .empty-state a { color:var(--accent-blue); }

        /* Modal */
        .modal-overlay {
            position:fixed; inset:0; background:rgba(0,0,0,0.7);
            backdrop-filter:blur(4px); z-index:200;
            display:flex; align-items:center; justify-content:center;
            opacity:0; pointer-events:none; transition:opacity 0.2s;
        }
        .modal-overlay.show { opacity:1; pointer-events:all; }
        .modal {
            background:#ffffff; border:1px solid var(--border);
            box-shadow:0 20px 60px rgba(0,0,0,0.15);
            border-radius:14px; padding:2rem; max-width:380px; width:90%;
            transform:scale(0.95); transition:transform 0.2s;
        }
        .modal-overlay.show .modal { transform:scale(1); }
        .modal-icon { font-size:2.5rem; margin-bottom:1rem; }
        .modal h3   { font-size:1.1rem; font-weight:700; margin-bottom:0.5rem; }
        .modal p    { font-size:0.875rem; color:var(--text-secondary); line-height:1.5; }
        .modal-actions { display:flex; gap:10px; margin-top:1.5rem; }
        .modal-btn {
            flex:1; padding:10px; border-radius:8px; border:none;
            font-family:'Sora',sans-serif; font-size:0.875rem; font-weight:600;
            cursor:pointer; transition:all 0.2s; text-align:center; text-decoration:none;
            display:flex; align-items:center; justify-content:center;
        }
        .modal-btn.cancel  { background:#f7faff; color:var(--text-secondary); border:1px solid var(--border); }
        .modal-btn.confirm { background:var(--accent-red); color:#fff; }
        .modal-btn.confirm:hover { background:#ff2040; }

        /* Toast */
        .toast {
            position:fixed; bottom:2rem; right:2rem;
            background:#ffffff; border:1px solid var(--border);
            border-left:3px solid var(--accent-green);
            border-radius:10px; padding:1rem 1.25rem; font-size:0.875rem;
            z-index:300; transform:translateY(100px); opacity:0; transition:all 0.3s;
            display:flex; align-items:center; gap:10px;
            box-shadow:0 4px 20px rgba(0,0,0,0.1);
        }
        .toast.show { transform:translateY(0); opacity:1; }

        @keyframes fadeDown { from{opacity:0;transform:translateY(-12px)} to{opacity:1;transform:translateY(0)} }
        @keyframes fadeUp   { from{opacity:0;transform:translateY(12px)}  to{opacity:1;transform:translateY(0)} }

        @media(max-width:768px){
            .main { padding:1rem; }
            .page-header { flex-direction:column; gap:1rem; }
            .stats-row { grid-template-columns:1fr 1fr; }
            td.hide-mobile, th.hide-mobile { display:none; }
        }
    </style>
</head>
<body>
<div class="layout">

    <header class="header">
        <div class="header-brand">
            <div class="brand-icon">🏠</div>
            <span class="brand-name">MiPágina</span>
        </div>
        <nav class="header-nav">
            <a href="#" class="nav-link">Dashboard</a>
            <a href="index.php" class="nav-link active">Usuarios</a>
            <a href="../clientes/index.php" class="nav-link">Clientes</a>
        </nav>
    </header>

    <main class="main">

        <!-- Page header -->
        <div class="page-header">
            <div class="page-title-group">
                <div class="breadcrumb">
                    <a href="#">inicio</a>
                    <span>/</span>
                    <span>usuarios</span>
                </div>
                <h1>Lista de Usuarios</h1>
                <p>Gestiona los usuarios registrados en el sistema</p>
            </div>
            <a href="nuevo.php" class="btn-new">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="8" x2="12" y2="16"/>
                    <line x1="8" y1="12" x2="16" y2="12"/>
                </svg>
                Nuevo Usuario
            </a>
        </div>

        <!-- Stats -->
        <div class="stats-row">
            <div class="stat-card">
                <div class="stat-icon si-blue">👥</div>
                <div>
                    <div class="stat-value"><?= $total ?></div>
                    <div class="stat-label">Total usuarios</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon si-yellow">🛡️</div>
                <div>
                    <div class="stat-value"><?= $admins ?></div>
                    <div class="stat-label">Administradores</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon si-cyan">👤</div>
                <div>
                    <div class="stat-value"><?= $regulares ?></div>
                    <div class="stat-label">Usuarios regulares</div>
                </div>
            </div>
        </div>

        <!-- Toolbar -->
        <div class="toolbar">
            <div class="search-box">
                <svg class="search-icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input type="text" id="searchInput" placeholder="Buscar por nombre o correo..." oninput="filterTable()">
            </div>
            <select class="filter-select" id="rolFilter" onchange="filterTable()">
                <option value="">Todos los roles</option>
                <option value="1">Administrador</option>
                <option value="0">Usuario</option>
            </select>
            <span class="records-count" id="recordsCount"><?= $total ?> registro<?= $total !== 1 ? 's' : '' ?></span>
        </div>

        <!-- Table -->
        <div class="table-wrapper">
            <?php if (empty($usuarios)): ?>
            <div class="empty-state">
                <div class="icon">👥</div>
                <p>No hay usuarios registrados. <a href="nuevo.php">Crear el primero</a></p>
            </div>
            <?php else: ?>
            <table id="usersTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Usuario</th>
                        <th class="hide-mobile">Correo</th>
                        <th class="hide-mobile center">Rol</th>
                        <th class="center">Acciones</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                <?php
                $colors = ['#3d7eff','#00d4ff','#7c3aed','#f59e0b','#10b981','#ef4444','#8b5cf6'];
                foreach ($usuarios as $i => $u):
                    $words    = explode(' ', trim($u['nombre']));
                    $initials = strtoupper(substr($words[0],0,1) . (isset($words[1]) ? substr($words[1],0,1) : ''));
                    $c        = $colors[$i % count($colors)];
                    $isAdmin  = $u['es_admin'] == 1;
                ?>
                <tr data-nombre="<?= strtolower(htmlspecialchars($u['nombre'])) ?>"
                    data-correo="<?= strtolower(htmlspecialchars($u['correo'])) ?>"
                    data-rol="<?= (int)$u['es_admin'] ?>">
                    <td>
                        <span style="font-family:'JetBrains Mono',monospace;font-size:0.78rem;color:var(--text-muted)">
                            #<?= str_pad($u['id'],3,'0',STR_PAD_LEFT) ?>
                        </span>
                    </td>
                    <td>
                        <div class="user-cell">
                            <div class="avatar" style="background:<?= $c ?>22;color:<?= $c ?>;border:1px solid <?= $c ?>44">
                                <?= $initials ?>
                            </div>
                            <div>
                                <div class="user-name"><?= htmlspecialchars($u['nombre']) ?></div>
                                <div class="user-id">id: <?= $u['id'] ?></div>
                            </div>
                        </div>
                    </td>
                    <td class="hide-mobile">
                        <span class="email-text"><?= htmlspecialchars($u['correo']) ?></span>
                    </td>
                    <td class="hide-mobile center">
                        <?php if ($isAdmin): ?>
                            <span class="badge badge-admin"><span class="badge-dot"></span>Administrador</span>
                        <?php else: ?>
                            <span class="badge badge-user"><span class="badge-dot"></span>Usuario</span>
                        <?php endif; ?>
                    </td>
                    <td class="center">
                        <div class="actions">
                            <a href="ver.php?id=<?= $u['id'] ?>" class="btn-action btn-view" title="Ver">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                            </a>
                            <a href="editar.php?id=<?= $u['id'] ?>" class="btn-action btn-edit" title="Editar">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                </svg>
                            </a>
                            <button class="btn-action btn-delete" title="Eliminar"
                                onclick="confirmDelete(<?= $u['id'] ?>,'<?= htmlspecialchars($u['nombre'],ENT_QUOTES) ?>')">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="3 6 5 6 21 6"/>
                                    <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                                    <path d="M10 11v6"/><path d="M14 11v6"/>
                                    <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <?php endif; ?>

            <div class="empty-state" id="emptySearch" style="display:none;">
                <div class="icon">🔍</div>
                <p>No se encontraron usuarios con ese criterio.</p>
            </div>
        </div>

    </main>
</div>

<!-- Modal eliminación -->
<div class="modal-overlay" id="deleteModal">
    <div class="modal">
        <div class="modal-icon">🗑️</div>
        <form method="POST" action="delete.php" id="deleteForm">
            <input type="hidden" name="id" id="deleteId" value="">
            <h3>¿Eliminar usuario?</h3>
            <p id="modalMsg">Esta acción no se puede deshacer.</p>
            <div class="modal-actions">
                <button type="button" class="modal-btn cancel" onclick="closeModal()">Cancelar</button>
                <button type="submit" class="modal-btn confirm" id="confirmBtn">Sí, eliminar</button>
            </div>
        </form>
    </div>
</div>

<!-- Toast -->
<div class="toast" id="toast">✅ <span id="toastMsg"></span></div>

<script>
function confirmDelete(id, nombre) {
    document.getElementById('modalMsg').textContent =
        `¿Seguro que deseas eliminar a "${nombre}"? Esta acción no se puede deshacer.`;
    document.getElementById('deleteId').value = id;
    document.getElementById('deleteModal').classList.add('show');
}

function closeModal() {
    document.getElementById('deleteModal').classList.remove('show');
    document.getElementById('deleteForm').reset();
}

// Cerrar modal al hacer clic en el overlay
document.getElementById('deleteModal').addEventListener('click', e => {
    if (e.target === document.getElementById('deleteModal')) closeModal();
});

function filterTable() {
    const search = document.getElementById('searchInput').value.toLowerCase();
    const rol    = document.getElementById('rolFilter').value;
    const rows   = document.querySelectorAll('#tableBody tr');
    let visible  = 0;
    rows.forEach(row => {
        const nombre = row.dataset.nombre || '';
        const correo = row.dataset.correo || '';
        const ok = (nombre.includes(search) || correo.includes(search))
                && (rol === '' || row.dataset.rol === rol);
        row.style.display = ok ? '' : 'none';
        if (ok) visible++;
    });
    document.getElementById('recordsCount').textContent = `${visible} registro${visible!==1?'s':''}`;
    document.getElementById('emptySearch').style.display = visible === 0 ? 'block' : 'none';
}

// Toast si viene de eliminar
const urlParams = new URLSearchParams(window.location.search);
if (urlParams.get('deleted') === '1') {
    const t = document.getElementById('toast');
    document.getElementById('toastMsg').textContent = 'Usuario eliminado correctamente';
    t.classList.add('show');
    setTimeout(() => t.classList.remove('show'), 3000);
    
    // Limpiar parámetro de la URL sin recargar
    const newUrl = window.location.pathname;
    window.history.replaceState({}, document.title, newUrl);
}

// Toast para mensajes de sesión
<?php if (isset($_SESSION['mensaje'])): ?>
    (function() {
        const t = document.getElementById('toast');
        document.getElementById('toastMsg').textContent = '<?= $_SESSION['mensaje'] ?>';
        t.classList.add('show');
        setTimeout(() => t.classList.remove('show'), 3000);
    })();
    <?php unset($_SESSION['mensaje']); ?>
<?php endif; ?>
</script>