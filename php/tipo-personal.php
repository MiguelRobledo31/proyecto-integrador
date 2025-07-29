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




      <form method="POST" class="fila-controles">

        <div class="paginacion-select">
          <label>
            <i class="bi bi-funnel-fill"></i>
            Mostrar
            <select name="limite" onchange="this.form.submit()">
              <option value="10" <?= isset($_POST['limite']) && $_POST['limite'] == 10 ? 'selected' : '' ?>>10</option>
              <option value="25" <?= isset($_POST['limite']) && $_POST['limite'] == 25 ? 'selected' : '' ?>>25</option>
              <option value="50" <?= isset($_POST['limite']) && $_POST['limite'] == 50 ? 'selected' : '' ?>>50</option>
            </select> entradas
          </label>
        </div>


        <div class="campo-busqueda">
          <i class="bi bi-search"></i>
          <input type="search" name="buscar" placeholder="Buscar..." value="<?= isset($_POST['buscar']) ? htmlspecialchars($_POST['buscar']) : '' ?>">
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

        <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 15px;">
          <button class="btn-agregar" onclick="window.location.href='servicios/registrar-personal.php?tipo=<?= urlencode($tipo) ?>'">
            <i class="bi bi-person-plus-fill" style="margin-right: 8px;"></i> Agregar <?= ucfirst($tipo) ?>
          </button>

          <button class="btn-agregar" onclick="window.location.href='servicios/importar-csv.php?tipo=<?= urlencode($tipo) ?>'">
            <i class="bi bi-download" style="margin-right: 8px;"></i> Importar <?= ucfirst($tipo) ?>
          </button>

          <button class="btn-agregar" onclick="window.location.href='servicios/exportar-csv.php?tipo=<?= urlencode($tipo) ?>'">
            <i class="bi bi-upload" style="margin-right: 8px;"></i> Exportar <?= ucfirst($tipo) ?>
          </button>
        </div>

      </div>
    </section>
  </main>
</body>

</html>