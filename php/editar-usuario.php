<?php
$conexion = new mysqli("localhost", "root", "", "sistema-control");
$conexion->set_charset("utf8");

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id'])) {
  $id = $_POST['id'];

  $resultado = $conexion->query("SELECT * FROM usuarios WHERE id = $id");
  $usuario = $resultado->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['actualizar'])) {
  $id = $_POST['id'];
  $usuario = $_POST['usuario'];
  $password = $_POST['password'];
  $nombre = $_POST['nombre'];
  $apellidos = $_POST['apellidos'];
  $rol = $_POST['rol'];

  $stmt = $conexion->prepare("UPDATE usuarios SET usuario=?, password=?, nombre=?, apellidos=?, rol=? WHERE id=?");
  $stmt->bind_param("sssssi", $usuario, $password, $nombre, $apellidos, $rol, $id);
  $stmt->execute();

  header("Location: usuarios.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Editar Usuario</title>
  <link rel="stylesheet" href="../css/sistema.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>

<body>


<aside class="sidebar">
  <img src="../img/logo.png" alt="UPTex" class="logo-sidebar" />
  <nav>
    <ul>
      <li><a href="../index.php"><i class="bi bi-house-door-fill"></i> Control de Acceso</a></li>
      <br /><br />
      <li><a href="../php/accesos.php"><i class="bi bi-bar-chart-line-fill"></i> Accesos</a></li>
      <li><a href="../html/personal.html" class="activo"><i class="bi bi-person-badge-fill"></i> Personal</a></li>
      <li><a href="../php/usuarios.php"><i class="bi bi-people-fill"></i> Usuarios</a></li>
    </ul>
  </nav>
</aside>


    <main class="main-content">
      <header class="topbar d-flex justify-content-between align-items-center px-3">
        <div></div>
        <a href="logout.php" class="btn-salir">
  <i class="bi bi-box-arrow-right" style="margin-right: 6px;"></i> Cerrar Sesión
</a>

      </header>
<section class="contenido">
  <h2>Editar Usuario</h2>

  <div class="formulario-container">
    <form method="POST">
      <input type="hidden" name="id" value="<?= $usuario['id'] ?>">

      <div class="form-group">
        <label for="usuario">Usuario:</label>
        <input type="text" id="usuario" name="usuario" value="<?= $usuario['usuario'] ?>" required>
      </div>

      <div class="form-group">
        <label for="password">Contraseña:</label>
        <input type="text" id="password" name="password" value="<?= $usuario['password'] ?>" required>
      </div>

      <div class="form-group">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="<?= $usuario['nombre'] ?>" required>
      </div>

      <div class="form-group">
        <label for="apellidos">Apellidos:</label>
        <input type="text" id="apellidos" name="apellidos" value="<?= $usuario['apellidos'] ?>" required>
      </div>

      <div class="form-group">
        <label for="rol">Rol:</label>
        <select id="rol" name="rol" required>
          <option value="administrador" <?= $usuario['rol'] === 'administrador' ? 'selected' : '' ?>>Administrador</option>
          <option value="asistente" <?= $usuario['rol'] === 'asistente' ? 'selected' : '' ?>>Asistente</option>
        </select>
      </div>

      <div class="botones-formulario">
        <a href="usuarios.php" class="btn-cancelar">
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