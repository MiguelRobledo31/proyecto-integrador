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
            <div id="iconoModal" style="font-size: 64px; margin-bottom: 15px; color: <?= $color ?>;"><?= $icono ?></div>
            <div id="mensajeModal"><?= $mensaje ?></div>
            <div id="detalleModal"><?= $detalle ?></div>
        </div>
    </div>
    <script>
        setTimeout(() => {
            window.location.href = "index.php";
        }, 1000);
    </script>
<?php endif; ?>