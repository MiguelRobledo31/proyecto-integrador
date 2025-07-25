<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $conexion = new mysqli("localhost", "root", "", "sistema-control");
    $conexion->set_charset("utf8"); $usuario = $_POST['usuario'] ?? '';
$password = $_POST['password'] ?? ''; $nombre = $_POST['nombre'] ?? '';
$apellidos = $_POST['apellidos'] ?? ''; $rol = $_POST['rol'] ?? ''; if ($usuario
&& $password && $nombre && $apellidos && $rol) { $stmt =
$conexion->prepare("INSERT INTO usuarios (usuario, password, nombre, apellidos,
rol) VALUES (?, ?, ?, ?, ?)"); $stmt->bind_param("sssss", $usuario, $password,
$nombre, $apellidos, $rol); $stmt->execute(); header("Location: ../usuarios.php");
exit; } } ?>

<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <title>Agregar Usuario</title>
    <link rel="stylesheet" href="../../css/sistema.css" />
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
      <li><a href="../php/usuarios.php"><i class="bi bi-people-fill"></i> Usuarios</a></li>
    </ul>
  </nav>
</aside>


    <main class="main-content">
      <header
        class="topbar d-flex justify-content-between align-items-center px-3"
      >
        <div></div>
        <a href="./logout.php" class="btn-salir">
  <i class="bi bi-box-arrow-right" style="margin-right: 6px;"></i> Cerrar Sesión
</a>

      </header>

      <section class="contenido">
        <h2>Agregar nuevo usuario</h2>

        <div class="formulario-container">
          <form method="POST">
            <div class="form-group">
              <label for="usuario">Usuario:</label>
              <input type="text" id="usuario" name="usuario" required />
            </div>

            <div class="form-group">
              <label for="password">Contraseña:</label>
              <input type="password" id="password" name="password" required />
            </div>

            <div class="form-group">
              <label for="nombre">Nombre:</label>
              <input type="text" id="nombre" name="nombre" required />
            </div>

            <div class="form-group">
              <label for="apellidos">Apellidos:</label>
              <input type="text" id="apellidos" name="apellidos" required />
            </div>

            <div class="form-group">
              <label for="rol">Rol:</label>
              <select id="rol" name="rol" required>
                <option value="administrador">Administrador</option>
                <option value="asistente">Asistente</option>
              </select>
            </div>

            <div class="botones-formulario">
              <a href="../usuarios.php" class="btn-cancelar">
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
