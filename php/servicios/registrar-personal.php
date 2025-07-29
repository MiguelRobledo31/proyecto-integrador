<?php
$conexion = new mysqli("localhost", "root", "", "sistema-control");
$conexion->set_charset("utf8");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $matricula = $_POST['matricula'] ?? '';
    $nombre = $_POST['nombre'] ?? '';
    $apellidos = $_POST['apellidos'] ?? '';
    $carrera = $_POST['carrera'] ?? '';
    $estado = isset($_POST['estado']) ? intval($_POST['estado']) : 0;
    $tipo = $_POST['tipo'] ?? '';
    $rutaFoto = '';

    $verificar = $conexion->prepare("SELECT matricula FROM personal WHERE matricula = ?");
    $verificar->bind_param("s", $matricula);
    $verificar->execute();
    $verificar->store_result();

    if ($verificar->num_rows > 0) {
        echo "<script>alert('Ya existe una persona con esa matrícula'); window.location.href = 'registrar-personal.php?tipo=" . urlencode($tipo) . "';</script>";
        exit;
    }
    $verificar->close();

    if ($matricula && $nombre && $apellidos && $tipo && ($tipo === 'alumno' ? $carrera : true)) {

        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
            $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
            $nombreFoto = $matricula . '.' . strtolower($ext);
            $destino = '../../fotos/' . $nombreFoto;
            move_uploaded_file($_FILES['foto']['tmp_name'], $destino);
            $rutaFoto = 'fotos/' . $nombreFoto;
        }

        $stmt = $conexion->prepare("INSERT INTO personal (matricula, nombre, apellidos, carrera, estado, tipo, foto) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssiss", $matricula, $nombre, $apellidos, $carrera, $estado, $tipo, $rutaFoto);
        $stmt->execute();
        header("Location: ../tipo-personal.php?tipo=$tipo");
        exit;
    }
}

$tipo = $_GET['tipo'] ?? '';
?>




<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <title>Registrar Personal</title>
    <link rel="stylesheet" href="../../css/sistema.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>

<body>
    <aside class="sidebar">
        <img src="../../img/logo.png" alt="UPTex" class="logo-sidebar" />
        <nav>
            <ul>
                <li><a href="../../index.php"><i class="bi bi-house-door-fill"></i> Control de Acceso</a></li>
                <br><br>
                <li><a href="../accesos.php"><i class="bi bi-bar-chart-line-fill"></i> Accesos</a></li>
                <li><a href="../../html/personal.html" class="activo"><i class="bi bi-person-badge-fill"></i> Personal</a></li>
                <li><a href="../usuarios.php"><i class="bi bi-people-fill"></i> Usuarios</a></li>
            </ul>
        </nav>
    </aside>

    <main class="main-content">
        <header class="topbar d-flex justify-content-between align-items-center px-3">
            <div></div>
            <a href="./logout.php" class="btn-salir">
                <i class="bi bi-box-arrow-right" style="margin-right: 6px;"></i> Cerrar Sesión
            </a>
        </header>

        <section class="contenido">
            <h2>Agregar nuevo personal</h2>
            <div class="formulario-container">
                <form method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="matricula">Matrícula:</label>
                        <input type="text" id="matricula" name="matricula" required>
                    </div>

                    <div class="form-group">
                        <label for="nombre">Nombre:</label>
                        <input type="text" id="nombre" name="nombre" required>
                    </div>

                    <div class="form-group">
                        <label for="apellidos">Apellidos:</label>
                        <input type="text" id="apellidos" name="apellidos" required>
                    </div>

                    <div class="form-group">
                        <label for="carrera">Carrera:</label>
                        <input type="text" id="carrera" name="carrera" <?= $tipo === 'alumno' ? 'required' : '' ?>>
                    </div>


                    <div class="form-group">
                        <label for="estado">Estado:</label>
                        <select id="estado" name="estado" required>
                            <option value="1" selected>Activo</option>
                            <option value="0">Inactivo</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="foto">Foto (opcional):</label>
                        <input type="file" id="foto" name="foto" accept="image/*">
                    </div>



                    <input type="hidden" name="tipo" value="<?= htmlspecialchars($_GET['tipo'] ?? '') ?>">

                    <div class="botones-formulario">
                        <a href="../tipo-personal.php?tipo=<?= htmlspecialchars($_GET['tipo'] ?? '') ?>" class="btn-cancelar">
                            <i class="bi bi-x-circle-fill" style="margin-right: 6px;"></i> Cancelar
                        </a>
                        <button type="submit" class="btn-aceptar">
                            <i class="bi bi-check-circle-fill" style="margin-right: 6px;"></i> Aceptar
                        </button>
                    </div>
                </form>
            </div>
        </section>
    </main>
</body>

</html>