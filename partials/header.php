<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">

        <a class="navbar-brand" href="/intranet/inicio.php">
            Intranet
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">

            <ul class="navbar-nav me-auto">

                <li class="nav-item">
                    <a class="nav-link" href="/intranet/inicio.php">Inicio</a>
                </li>

                <?php if (in_array($_SESSION['rol'], ['admin', 'supervisor'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/intranet/usuarios.php">
                            Usuarios
                        </a>
                    </li>
                <?php endif; ?>

                <?php if ($_SESSION['rol'] === 'admin'): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/intranet/admin/usuarios_crear.php">
                            Crear usuario
                        </a>
                    </li>
                <?php endif; ?>

            </ul>

            <form method="post" action="/intranet/logout.php" class="d-flex">
                <button class="btn btn-danger btn-sm">
                    Cerrar sesión
                </button>
            </form>

        </div>
    </div>
</nav>
