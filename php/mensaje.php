<?php
session_start();
$mensaje = $_SESSION['mensaje'] ?? null;
$detalle = $_SESSION['detalle'] ?? null;
$tipo = $_SESSION['tipo'] ?? null;
$icono = $_SESSION['icono'] ?? null;
$color = $_SESSION['color'] ?? 'green';
unset($_SESSION['mensaje'], $_SESSION['detalle'], $_SESSION['tipo'], $_SESSION['icono'], $_SESSION['color']);
?>

<?php if ($mensaje): ?>
  <div id="modal" style="display: flex;">
    <div class="contenido-modal">
      <div id="iconoModal">
        <i class="bi <?= $icono ?>" style="color: <?= $color ?>; font-size: 64px; margin-bottom: 15px;"></i>
      </div>
      <div id="mensajeModal"><?= $mensaje ?></div>
      <div id="detalleModal"><?= $detalle ?></div>
    </div>
  </div>
  <script>
    setTimeout(() => {
      window.location.href = "index.php";
    }, 3000);
  </script>
<?php endif; ?>
