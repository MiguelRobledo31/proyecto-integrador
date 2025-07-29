<?php
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['matricula'])) {
    $conexion = new mysqli("localhost", "root", "", "sistema-control");
    $conexion->set_charset("utf8");

    $matricula = $_POST['matricula'];
    $tipo = $_POST['tipo'] ?? $_GET['tipo'] ?? '';

    $stmt = $conexion->prepare("DELETE FROM personal WHERE matricula = ?");
    $stmt->bind_param("s", $matricula);
    $stmt->execute();
}

$tipo = $_POST['tipo'] ?? $_GET['tipo'] ?? '';

header("Location: ../tipo-personal.php?tipo=" . urlencode($tipo));
exit;
