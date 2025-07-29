<?php
session_start();
$mensaje = $_SESSION['mensaje'] ?? null;
$detalle = $_SESSION['detalle'] ?? null;
$tipo = $_SESSION['tipo'] ?? null;
$icono = $_SESSION['icono'] ?? null;
$color = $_SESSION['color'] ?? 'green';
$foto = $_SESSION['foto'] ?? null;

unset($_SESSION['mensaje'], $_SESSION['detalle'], $_SESSION['tipo'], $_SESSION['icono'], $_SESSION['color'], $_SESSION['foto']);
?>

<?php if ($mensaje): ?>
  <div id="modal" style="display: flex;">
    <div class="contenido-modal">
      <div id="iconoModal">
        <i class="bi <?= $icono ?>" style="color: <?= $color ?>; font-size: 64px; margin-bottom: 15px;"></i>
      </div>

      <?php if ($foto): ?>
        <div style="margin: 15px 0;">
          <img src="../<?= htmlspecialchars($foto) ?>" alt="Foto" style="max-width: 150px; border-radius: 8px; box-shadow: 0 0 5px rgba(0,0,0,0.2);">
        </div>
      <?php endif; ?>

      <div id="mensajeModal"><?= $mensaje ?></div>
      <div id="detalleModal"><?= $detalle ?></div>
    </div>
  </div>
  <script>
    setTimeout(() => {
      window.location.href = location.pathname;
    }, 3000);
  </script>
<?php endif; ?>
