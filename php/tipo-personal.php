<?php
$conexion = new mysqli("localhost", "root", "", "sistema-control");
$conexion->set_charset("utf8"); $tipo = $_GET['tipo'] ?? ''; $tipo =
$conexion->real_escape_string(strtolower($tipo)); $consulta = "SELECT * FROM
personal WHERE tipo = '$tipo' ORDER BY apellidos ASC"; $resultado =
$conexion->query($consulta); ?>

<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <title>Listado de <?= ucfirst($tipo) ?></title>
    <link rel="stylesheet" href="../css/sistema.css" />
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
      <header
        class="topbar d-flex justify-content-between align-items-center px-3"
      >
        <div></div>
        <a href="servicios/logout.php" class="btn-salir">
  <i class="bi bi-box-arrow-right" style="margin-right: 6px;"></i> Cerrar Sesión
</a>

      </header>

      <section class="contenido">
        <h2>
          Listado de
          <?= ucfirst($tipo) ?>
        </h2>

        <form method="POST" class="controles-tabla">
          <div style="display: flex; gap: 5px">
            <input
              type="search"
              name="buscar"
              placeholder="Buscar..."
              value="<?php echo isset($_POST['buscar']) ? htmlspecialchars($_POST['buscar']) : ''; ?>"
            />
            <button type="submit">Buscar</button>
          </div>
        </form>

        <div class="tabla-container">
          <table>
            <thead>
              <tr>
                <th>Matrícula</th>
                <th>Nombre</th>
                <th>Apellidos</th>
                <th>Carrera</th>
                <th>Estado</th>
              </tr>
            </thead>
            <tbody>
              <?php if ($resultado->num_rows > 0): ?>
              <?php while ($fila = $resultado->fetch_assoc()): ?>
              <tr>
                <td><?= htmlspecialchars($fila['matricula']) ?></td>
                <td><?= htmlspecialchars($fila['nombre']) ?></td>
                <td><?= htmlspecialchars($fila['apellidos']) ?></td>
                <td><?= htmlspecialchars($fila['carrera']) ?></td>
                <td><?= $fila['estado'] ? 'Activo' : 'Inactivo' ?></td>
              </tr>
              <?php endwhile; ?>
              <?php else: ?>
              <tr>
                <td colspan="5">No hay registros para este tipo.</td>
              </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </section>
    </main>
  </body>
</html>
