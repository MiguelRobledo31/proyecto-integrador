<?php
$conn = new mysqli("localhost", "root", "", "sistema-control");

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
