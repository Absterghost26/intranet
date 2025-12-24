<?php
require_once __DIR__ . "/../config/auth.php";
requireLogin();
requireRole(['admin']);
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Crear Usuario · Intranet</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<?php require_once __DIR__ . "/../partials/header.php"; ?>

<div class="container py-4">

    <div class="card shadow-sm">
        <div class="card-body">

            <h1 class="fw-bold text-center mb-4">Crear nuevo usuario</h1>

            <form method="post" action="usuarios_guardar.php">

                <div class="mb-3">
                    <label class="form-label">Correo electrónico</label>
                    <input type="email" name="email" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Rol</label>
                    <select name="rol" class="form-select" required>
                        <option value="">Seleccione un rol</option>
                        <option value="admin">Administrador</option>
                        <option value="supervisor">Supervisor</option>
                        <option value="usuario">Usuario</option>
                    </select>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="../usuarios.php" class="btn btn-secondary">Volver</a>
                    <button type="submit" class="btn btn-primary">
                        Crear usuario
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>

<script src="../assets/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
