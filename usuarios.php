<?php
require_once __DIR__ . "/config/auth.php";
require_once __DIR__ . "/config/db.php";

requireLogin();
requireRole(['admin', 'supervisor']);

$sql = "SELECT id, email, rol, estado, fecha_creacion
        FROM usuarios
        ORDER BY fecha_creacion DESC";

$resultado = $conexion->query($sql);
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

    <h1 class="fw-bold mb-4">Gestión de Usuarios</h1>

    <div class="card shadow-sm">
        <div class="card-body table-responsive">

            <table class="table table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Estado</th>
                        <th>Fecha creación</th>
                        <?php if ($_SESSION['rol'] === 'admin'): ?>
                            <th>Acciones</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                <?php while ($u = $resultado->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($u['email']) ?></td>
                        <td><?= ucfirst($u['rol']) ?></td>
                        <td>
                            <?= $u['estado'] ? 
                                '<span class="badge bg-success">Activo</span>' :
                                '<span class="badge bg-danger">Inactivo</span>' ?>
                        </td>
                        <td><?= date("d/m/Y", strtotime($u['fecha_creacion'])) ?></td>

                        <?php if ($_SESSION['rol'] === 'admin'): ?>
                        <td>
                            <a href="/intranet/admin/usuarios_editar.php?id=<?= $u['id'] ?>"
                               class="btn btn-sm btn-warning">
                                Editar
                            </a>
                            <a href="/intranet/admin/usuarios_eliminar.php?id=<?= $u['id'] ?>"
                               class="btn btn-sm btn-danger"
                               onclick="return confirm('¿Eliminar usuario?')">
                                Eliminar
                            </a>
                        </td>
                        <?php endif; ?>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>

        </div>
    </div>

</div>

<script src="assets/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
