<?php
require_once __DIR__ . "/config/auth.php";
requireLogin();
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Inicio · Intranet</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<?php require_once __DIR__ . "/partials/header.php"; ?>

<div class="container py-4">

    <?php if (isset($_SESSION["flash"])): ?>
        <div class="alert alert-success alert-dismissible fade show text-center">
            <?= htmlspecialchars($_SESSION["flash"]) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php unset($_SESSION["flash"]); ?>
    <?php endif; ?>

    <!-- BIENVENIDA -->
    <div class="mb-4 text-center">
        <h1 class="fw-bold">Bienvenido a la Intranet GTI</h1>
        <p class="text-muted fs-5">
            Accede a las herramientas internas del sistema
        </p>
    </div>

    <!-- ACCESOS RÁPIDOS -->
    <div class="row g-4">

        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <h5 class="fw-bold">Mi Perfil</h5>
                    <p class="text-muted small">
                        Consulta tu información personal y estado de cuenta.
                    </p>
                    <a href="#" class="btn btn-outline-primary btn-sm">
                        Ver perfil
                    </a>
                </div>
            </div>
        </div>

        <?php if ($_SESSION["rol"] === "admin"): ?>
        <div class="col-md-4">
            <div class="card shadow-sm h-100 border-primary">
                <div class="card-body text-center">
                    <h5 class="fw-bold">Usuarios</h5>
                    <p class="text-muted small">
                        Administración de usuarios y roles.
                    </p>
                    <a href="usuarios.php" class="btn btn-primary btn-sm">
                        Gestionar
                    </a>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <h5 class="fw-bold">Soporte</h5>
                    <p class="text-muted small">
                        Reporta incidencias o solicita ayuda.
                    </p>
                    <a href="#" class="btn btn-outline-secondary btn-sm">
                        Contactar
                    </a>
                </div>
            </div>
        </div>

    </div>

    <!-- INFORMACIÓN GENERAL -->
    <div class="card shadow-sm mt-5">
        <div class="card-body">
            <h5 class="fw-bold">Avisos internos</h5>
            <ul class="mb-0">
                <li>Mantenimiento programado este fin de semana.</li>
                <li>Actualización de políticas internas.</li>
                <li>Nuevos módulos disponibles próximamente.</li>
            </ul>
        </div>
    </div>

    <footer class="text-center text-muted mt-5">
        &copy; <?= date("Y") ?> Intranet GTI
    </footer>

</div>

<script src="assets/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
