<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Listado de Personal</title>
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
  <header class="topbar d-flex justify-content-between align-items-center px-3">
    <div></div>
    <a href="servicios/logout.php" class="btn-salir">
      <i class="bi bi-box-arrow-right" style="margin-right: 6px;"></i> Cerrar Sesión
    </a>
  </header>

  <section class="contenido">
    <?php
      $tipo = $_GET['tipo'] ?? '';
      $tipoMostrar = htmlspecialchars(ucfirst($tipo));
    ?>
    <h2>Listado de <?= $tipoMostrar ?></h2>

    <form method="GET" class="controles-tabla">
      <div style="display: flex; gap: 5px">
        <input type="search" name="buscar" placeholder="Buscar..." value="<?= isset($_GET['buscar']) ? htmlspecialchars($_GET['buscar']) : '' ?>" />
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
          <?php include 'servicios/filtrar-personal.php'; ?>
        </tbody>
      </table>
    </div>
  </section>
</main>
</body>
</html>
