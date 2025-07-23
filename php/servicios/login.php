<?php
session_start();
include(__DIR__ . "/../conexion.php");

$usuario = $_POST['usuario'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($usuario) || empty($password)) {
    header("Location: ../admin.php?error=" . urlencode("Por favor completa ambos campos"));
    exit;
}

$stmt = $conn->prepare("SELECT * FROM usuarios WHERE usuario = ? AND password = ?");
$stmt->bind_param("ss", $usuario, $password);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {
    $_SESSION['usuario'] = $usuario;
    header("Location: ../accesos.php");
    exit;
} else {
    header("Location: ../admin.php?error=" . urlencode("Usuario o contraseña incorrectos."));
    exit;
}
