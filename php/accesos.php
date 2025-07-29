<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Registros de Acceso</title>
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
        <li><a href="./accesos.php" class="activo"><i class="bi bi-bar-chart-line-fill"></i> Accesos</a></li>
        <li><a href="../html/personal.html"><i class="bi bi-person-badge-fill"></i> Personal</a></li>
        <li><a href="./usuarios.php"><i class="bi bi-people-fill"></i> Usuarios</a></li>
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

    <section class="contenido px-4 pt-4">
      <h2 class="mb-3">Registros de Acceso</h2>

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
  <?php include("servicios/listar-accesos.php"); ?>

  <div style="display: flex; justify-content: flex-end; margin-top: 10px;">
    <button class="btn-agregar" onclick="window.location.href='servicios/exportar-accesos.php'">
      <i class="bi bi-file-earmark-arrow-up"></i> Exportar Accesos
    </button>
  </div>
</div>

    </section>
  </main>

</body>

</html>