<?php
$tipo = $_GET['tipo'] ?? '';
$tipoMostrar = ucfirst($tipo);
$conexion = new mysqli("localhost", "root", "", "sistema-control");
$conexion->set_charset("utf8");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['importar'])) {
  $tipo = $_POST['tipo'] ?? '';
  $csv = $_FILES['archivo_csv']['tmp_name'] ?? null;
  $zip = $_FILES['archivo_zip']['tmp_name'] ?? null;
  $rutaFotos = '../../fotos/';

  if ($zip && is_uploaded_file($zip)) {
    $zipObj = new ZipArchive;
    if ($zipObj->open($zip) === TRUE) {
      $zipObj->extractTo($rutaFotos);
      $zipObj->close();
    } else {
      echo "<script>alert('Error al descomprimir el archivo ZIP');</script>";
    }
  }

  if ($csv && is_uploaded_file($csv)) {
    $handle = fopen($csv, 'r');
    $encabezados = fgetcsv($handle);

    while (($fila = fgetcsv($handle)) !== false) {
      list($matricula, $nombre, $apellidos, $carrera, $estado, $foto) = $fila;

      $verificar = $conexion->prepare("SELECT matricula FROM personal WHERE matricula = ?");
      $verificar->bind_param("s", $matricula);
      $verificar->execute();
      $verificar->store_result();

      if ($verificar->num_rows > 0) {
        $verificar->close();
        continue;
      }
      $verificar->close();

      if (!$foto) {
        if (file_exists($rutaFotos . $matricula . '.png')) {
          $foto = "fotos/{$matricula}.png";
        } elseif (file_exists($rutaFotos . $matricula . '.jpg')) {
          $foto = "fotos/{$matricula}.jpg";
        } else {
          $foto = '';
        }
      }


      $stmt = $conexion->prepare("INSERT INTO personal (matricula, nombre, apellidos, carrera, estado, tipo, foto) VALUES (?, ?, ?, ?, ?, ?, ?)");
      $stmt->bind_param("ssssiss", $matricula, $nombre, $apellidos, $carrera, $estado, $tipo, $foto);
      $stmt->execute();
    }

    fclose($handle);
    echo "<script>alert('Importación finalizada correctamente'); window.location.href = '../tipo-personal.php?tipo=" . urlencode($tipo) . "';</script>";
    exit;
  } else {
    echo "<script>alert('Archivo CSV inválido o no cargado');</script>";
  }
}
?>


<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <title>Importar <?= $tipoMostrar ?></title>
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
      <h2>Importar <?= $tipoMostrar ?> desde CSV</h2>

      <div class="formulario-container">
        <form method="POST" enctype="multipart/form-data">
          <div class="form-group">
            <label for="archivo_csv">Archivo CSV:</label>
            <input type="file" name="archivo_csv" accept=".csv" required>
          </div>

          <div class="form-group">
            <label for="archivo_zip">ZIP de fotos (opcional):</label>
            <input type="file" name="archivo_zip" accept=".zip">
          </div>

          <input type="hidden" name="tipo" value="<?= htmlspecialchars($tipo) ?>">

          <div class="botones-formulario">
            <a href="../tipo-personal.php?tipo=<?= urlencode($tipo) ?>" class="btn-cancelar">
              <i class="bi bi-x-circle-fill" style="margin-right: 6px;"></i> Cancelar
            </a>
            <button type="submit" name="importar" class="btn-aceptar">
              <i class="bi bi-upload" style="margin-right: 6px;"></i> Importar
            </button>
          </div>
        </form>
      </div>
    </section>
  </main>
</body>

</html>