<?php
require_once __DIR__ . "/config/auth.php";

requireLogin();
requireRole(['admin', 'supervisor']);
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Usuarios · Intranet</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<?php require_once __DIR__ . "/partials/header.php"; ?>

<div class="container py-4">

    <div class="card shadow-sm">
        <div class="card-body text-center">

            <h1 class="fw-bold mb-3">Gestión de Usuarios</h1>

            <p class="fs-5 text-muted">
                Esta sección solo es accesible para administradores.
            </p>

            <div class="alert alert-info mt-4">
                <strong>Usuario conectado:</strong>
                <?= htmlspecialchars($_SESSION["email"]) ?>
                <br>
                <strong>Rol:</strong>
                <?= htmlspecialchars($_SESSION["rol"]) ?>
            </div>

            <p class="mt-4 text-muted">
                Aquí podrás crear, editar y administrar usuarios del sistema.
            </p>

        </div>
    </div>

    <footer class="text-center text-muted mt-5">
        &copy; <?= date("Y") ?> Intranet GTI
    </footer>

</div>

<script src="assets/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
