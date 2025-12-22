<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["usuario_id"])) {
    header("Location: index.php");
    exit;
}

$rol = $_SESSION["rol"];
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">

        <a class="navbar-brand fw-bold" href="/inicio.php">
            Intranet GTI
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">

            <ul class="navbar-nav me-auto">

                <!-- Visible para TODOS -->
                <li class="nav-item">
                    <a class="nav-link" href="/inicio.php">Inicio</a>
                </li>

                <!-- ADMIN y SUPERVISOR -->
                <?php if (in_array($rol, ['admin', 'supervisor'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/usuarios.php">
                            Usuarios
                        </a>
                    </li>
                <?php endif; ?>

                <!-- SOLO ADMIN -->
                <?php if ($rol === 'admin'): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/usuarios_crear.php">
                            Crear usuario
                        </a>
                    </li>
                <?php endif; ?>

            </ul>

            <span class="navbar-text text-white me-3">
                <?= htmlspecialchars($_SESSION["email"]) ?>
                (<?= htmlspecialchars($rol) ?>)
            </span>

            <form method="post" action="/logout.php">
                <button type="submit" class="btn btn-danger btn-sm">
                    Cerrar sesión
                </button>
            </form>

        </div>
    </div>
</nav>
