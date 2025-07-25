<?php
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id'])) {
    $conexion = new mysqli("localhost", "root", "", "sistema-control");
    $conexion->set_charset("utf8");

    $id = $_POST['id'];

    $stmt = $conexion->prepare("DELETE FROM usuarios WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

header("Location: ../usuarios.php");
exit;
