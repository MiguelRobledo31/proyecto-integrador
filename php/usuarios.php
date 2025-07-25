<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Usuarios</title>
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
      <li><a href="./accesos.php"><i class="bi bi-bar-chart-line-fill"></i> Accesos</a></li>
      <li><a href="../html/personal.html" class="activo"><i class="bi bi-person-badge-fill"></i> Personal</a></li>
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

    <section class="contenido">
      <div class="encabezado-tabla">
        <h2>Listado de Usuarios para Iniciar Sesión<z/h2>
      </div>

      <form method="POST" class="controles-tabla">
        <label>Mostrar
          <select name="limite" onchange="this.form.submit()">
            <option value="10" <?php if (isset($_POST['limite']) && $_POST['limite'] == 10) echo 'selected'; ?>>10</option>
            <option value="25" <?php if (isset($_POST['limite']) && $_POST['limite'] == 25) echo 'selected'; ?>>25</option>
            <option value="50" <?php if (isset($_POST['limite']) && $_POST['limite'] == 50) echo 'selected'; ?>>50</option>
          </select> entradas
        </label>

        <div style="display: flex; gap: 5px;">
          <input type="search" name="buscar" placeholder="Buscar..." value="<?php echo isset($_POST['buscar']) ? htmlspecialchars($_POST['buscar']) : ''; ?>">
          <button type="submit">Buscar</button>
        </div>
      </form>



      <div class="tabla-container">
        <table>
        <thead>
          <tr>
            <th>Usuario</th>
            <th>Contraseña</th>
            <th>Nombre</th>
            <th>Apellidos</th>
            <th>Rol</th>
            <th>Acción</th>
          </tr>
        </thead>
        <tbody>
          <?php include 'servicios/listar-usuarios.php'; ?>
        </tbody>
        </table>
        <div style="display: flex; justify-content: flex-end; margin-top: 15px;">
          <button class="btn-agregar" onclick="window.location.href='servicios/registrar-usuario.php'">
            <i class="bi bi-person-plus-fill" style="margin-right: 8px;"></i> Agregar Usuario
          </button>
        </div>
      </div>
      </div>
    </section>
  </main>
</body>

</html>