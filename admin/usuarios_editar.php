<?php
require_once __DIR__ . "/../config/auth.php";
require_once __DIR__ . "/../config/db.php";

requireLogin();
requireRole(['admin']);

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: usuarios.php");
    exit;
}

$id = (int) $_GET['id'];

/* ===================== OBTENER USUARIO ===================== */
$stmt = $conexion->prepare("
    SELECT id, email, rol, estado
    FROM usuarios
    WHERE id = ?
    LIMIT 1
");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: usuarios.php");
    exit;
}

$usuario = $result->fetch_assoc();

/* ===================== ELIMINAR USUARIO ===================== */
if (isset($_POST['accion']) && $_POST['accion'] === 'eliminar') {

    $confirmEmail = trim($_POST['confirm_email']);

    if ($confirmEmail !== $usuario['email']) {
        $errorEliminar = "El correo ingresado no coincide.";
    } else {

        $stmt = $conexion->prepare("DELETE FROM usuarios WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        header("Location: usuarios.php");
        exit;
    }
}

/* ===================== GUARDAR CAMBIOS ===================== */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['accion'])) {

    $email  = trim($_POST['email']);
    $rol    = $_POST['rol'];
    $estado = isset($_POST['estado']) ? 1 : 0;
    $reset  = isset($_POST['reset_password']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "El correo electrónico no es válido.";
    } else {

        $stmt = $conexion->prepare("
            UPDATE usuarios
            SET email = ?, rol = ?, estado = ?
            WHERE id = ?
        ");
        $stmt->bind_param("ssii", $email, $rol, $estado, $id);
        $stmt->execute();

        if ($reset) {

            $passwordPlano = bin2hex(random_bytes(4));
            $hashPendiente = password_hash($passwordPlano, PASSWORD_DEFAULT);
            $token         = bin2hex(random_bytes(32));

            $stmt = $conexion->prepare("
                UPDATE usuarios
                SET clave_pendiente = ?,
                    token_activacion = ?,
                    fecha_token = NOW()
                WHERE id = ?
            ");
            $stmt->bind_param("ssi", $hashPendiente, $token, $id);
            $stmt->execute();

            $_SESSION['correo_simulado'] = [
                'email' => $email,
                'password' => $passwordPlano,
                'link' => "http://localhost/intranet/confirmar_clave.php?token=$token"
            ];
        }

        header("Location: usuarios.php");
        exit;
    }
}
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Editar usuario · Intranet</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<?php require_once __DIR__ . "/../partials/header.php"; ?>

<div class="container py-4">
<div class="row justify-content-center">
<div class="col-md-6">

<div class="card shadow-sm">
<div class="card-body">

<h4 class="fw-bold mb-4">Editar usuario</h4>

<?php if (isset($error)): ?>
<div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<form method="post">

<div class="mb-3">
<label class="form-label fw-bold">Correo electrónico</label>
<input type="email" name="email" class="form-control"
       value="<?= htmlspecialchars($usuario['email']) ?>" required>
</div>

<div class="mb-3">
<label class="form-label fw-bold">Rol</label>
<select name="rol" class="form-select" required>
<option value="usuario" <?= $usuario['rol']=='usuario'?'selected':'' ?>>Usuario</option>
<option value="supervisor" <?= $usuario['rol']=='supervisor'?'selected':'' ?>>Supervisor</option>
<option value="admin" <?= $usuario['rol']=='admin'?'selected':'' ?>>Administrador</option>
</select>
</div>

<div class="form-check mb-3">
<input class="form-check-input" type="checkbox" name="estado" id="estado"
       <?= $usuario['estado'] ? 'checked' : '' ?>>
<label class="form-check-label fw-bold" for="estado">
Usuario activo
</label>
</div>

<hr>

<div class="form-check mb-4">
<input class="form-check-input" type="checkbox" name="reset_password" id="reset">
<label class="form-check-label fw-bold text-danger" for="reset">
Generar contraseña aleatoria y solicitar confirmación
</label>
</div>

<div class="d-flex justify-content-between">
<a href="usuarios.php" class="btn btn-outline-secondary">Volver</a>
<button type="submit" class="btn btn-primary">Guardar cambios</button>
</div>

</form>

<hr class="my-4">

<!-- ================= ELIMINAR TIPO GITHUB ================= -->
<h5 class="fw-bold text-danger">Eliminar usuario</h5>

<?php if (isset($errorEliminar)): ?>
<div class="alert alert-danger"><?= htmlspecialchars($errorEliminar) ?></div>
<?php endif; ?>

<p class="small text-muted">
Para confirmar, escriba el correo exacto del usuario:
</p>

<form method="post" id="formEliminar">
<input type="hidden" name="accion" value="eliminar">

<div class="mb-3">
<input type="text"
       name="confirm_email"
       id="confirmEmail"
       class="form-control"
       placeholder="<?= htmlspecialchars($usuario['email']) ?>">
</div>

<button type="submit"
        id="btnEliminar"
        class="btn btn-danger w-100"
        disabled>
Eliminar definitivamente
</button>
</form>

</div>
</div>

</div>
</div>
</div>

<script src="../assets/dist/js/bootstrap.bundle.min.js"></script>

<script>
const input = document.getElementById('confirmEmail');
const btn = document.getElementById('btnEliminar');
const email = "<?= addslashes($usuario['email']) ?>";

input.addEventListener('input', () => {
    btn.disabled = input.value !== email;
});
</script>

</body>
</html>
