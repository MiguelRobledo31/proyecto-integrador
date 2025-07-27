<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Registro de Entrada</title>
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>

<body>
  <a href="admin.php?volver=entrada.php" class="admin-link">
    <i class="bi bi-person-lock" style="margin-right: 6px;"></i> Admin
  </a>

  <div class="contenedor">
    <h1>REGISTRA TU ENTRADA</h1>
    <div id="reloj"></div>

    <div class="formulario">
      <h2>Escanea la Matrícula</h2>
      <form method="POST" action="servicios/validar-matricula.php">

        <div class="campo-input">
          <i class="bi bi-qr-code-scan"></i>
          <input type="text" name="matricula" id="matricula" placeholder="Ingresa tu Matrícula" autofocus autocomplete="off">
        </div>

        <button type="submit">
          <i class="bi bi-box-arrow-in-right" style="margin-right: 6px;"></i> Entrada
        </button>
      </form>
    </div>
  </div>

  <?php include 'mensaje.php'; ?>

  <script src="../js/reloj.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
</body>

</html>