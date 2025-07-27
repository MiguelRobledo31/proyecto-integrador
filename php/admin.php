<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión - Administrador</title>
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>

<body>
    <?php
    $volver = $_GET['volver'] ?? '../index.php';
    ?>
    <a href="<?= htmlspecialchars($volver) ?>" class="btn-volver">
        <i class="bi bi-arrow-left-circle-fill" style="margin-right: 6px;"></i> Volver
    </a>

    <div class="login-container">
        <img src="../img/logo.png" alt="Logo" class="logo">

        <form action="servicios/login.php" method="POST" class="login-form">
            <div class="campo-input">
                <span class="icono-input"><i class="bi bi-person-fill"></i></span>
                <input type="text" name="usuario" placeholder="Usuario" required>
            </div>

            <div class="campo-input">
                <span class="icono-input"><i class="bi bi-lock-fill"></i></span>
                <input type="password" name="password" placeholder="Contraseña" required>
            </div>

            <button type="submit">
                <i class="bi bi-box-arrow-in-right" style="margin-right: 6px;"></i> Ingresar
            </button>
        </form>

        <?php if (isset($_GET['error'])): ?>
            <div class="error"><?php echo htmlspecialchars($_GET['error']); ?></div>
        <?php endif; ?>
    </div>
</body>

</html>