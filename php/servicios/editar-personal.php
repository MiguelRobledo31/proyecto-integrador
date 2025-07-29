<?php
$conexion = new mysqli("localhost", "root", "", "sistema-control");
$conexion->set_charset("utf8");

$tipo = $_POST['tipo'] ?? $_GET['tipo'] ?? '';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['matricula'])) {
  $matricula = $_POST['matricula'];

  $resultado = $conexion->query("SELECT * FROM personal WHERE matricula = '$matricula'");
  $persona = $resultado->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['actualizar'])) {
  $matricula = $_POST['matricula'];
  $nombre = $_POST['nombre'];
  $apellidos = $_POST['apellidos'];
  $carrera = $_POST['carrera'];
  $estado = $_POST['estado'];

  $matricula_original = $_POST['matricula_original'];
  $stmt = $conexion->prepare("UPDATE personal SET matricula=?, nombre=?, apellidos=?, carrera=?, estado=? WHERE matricula=?");
  $stmt->bind_param("ssssss", $matricula, $nombre, $apellidos, $carrera, $estado, $matricula_original);

  $stmt->execute();

  header("Location: ../tipo-personal.php?tipo=$tipo");
  exit;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Editar Personal</title>
  <link rel="stylesheet" href="../../css/sistema.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>

<body>
  <aside class="sidebar">
    <img src="../../img/logo.png" alt="UPTex" class="logo-sidebar" />
    <nav>
      <ul>
        <li><a href="../../index.php"><i class="bi bi-house-door-fill"></i> Control de Acceso</a></li>
        <br /><br />
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
      <h2>Editar Registro</h2>

      <div class="formulario-container">
        <form method="POST">
          <input type="hidden" name="matricula_original" value="<?= $persona['matricula'] ?>">

          <div class="form-group">
            <label for="matricula">Matrícula:</label>
            <input type="text" id="matricula" name="matricula" value="<?= $persona['matricula'] ?>" required>
          </div>

          <input type="hidden" name="tipo" value="<?= htmlspecialchars($persona['tipo']) ?>">


          <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="<?= $persona['nombre'] ?>" required>
          </div>

          <div class="form-group">
            <label for="apellidos">Apellidos:</label>
            <input type="text" id="apellidos" name="apellidos" value="<?= $persona['apellidos'] ?>" required>
          </div>

          <div class="form-group">
            <label for="carrera">Carrera:</label>
            <input type="text" id="carrera" name="carrera" value="<?= $persona['carrera'] ?>" required>
          </div>

          <div class="form-group">
            <label for="estado">Estado:</label>
            <select id="estado" name="estado" required>
              <option value="1" <?= $persona['estado'] ? 'selected' : '' ?>>Activo</option>
              <option value="0" <?= !$persona['estado'] ? 'selected' : '' ?>>Inactivo</option>
            </select>
          </div>

          <div class="botones-formulario">
            <a href="../tipo-personal.php?tipo=<?= $persona['tipo'] ?>" class="btn-cancelar">
              <i class="bi bi-x-circle-fill" style="margin-right: 6px;"></i> Cancelar
            </a>
            <button type="submit" name="actualizar" class="btn-aceptar">
              <i class="bi bi-arrow-repeat" style="margin-right: 6px;"></i> Actualizar
            </button>
          </div>
        </form>
      </div>
    </section>
  </main>
</body>

</html>