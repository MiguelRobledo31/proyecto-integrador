<?php
session_start();
date_default_timezone_set('America/Mexico_City');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $matricula = trim($_POST['matricula']);
    $tipo = $_POST['tipo'] ?? 'entrada'; // 'entrada' o 'salida'

    if (empty($matricula)) {
        $_SESSION['mensaje'] = "Matrícula vacía";
        $_SESSION['icono'] = "bi-x-circle-fill";
        $_SESSION['color'] = "red";
        $baseURL = dirname(dirname($_SERVER['PHP_SELF']));
        header("Location: {$baseURL}/{$tipo}.php");

        exit;
    }

    $conn = new mysqli("localhost", "root", "", "sistema-control");

    if ($conn->connect_error) {
        $_SESSION['mensaje'] = "Error de conexión con la base de datos";
        $_SESSION['icono'] = "bi-x-circle-fill";
        $_SESSION['color'] = "red";
        $baseURL = dirname(dirname($_SERVER['PHP_SELF']));
        header("Location: {$baseURL}/{$tipo}.php");

        exit;
    }

    $stmt = $conn->prepare("SELECT * FROM personal WHERE matricula = ?");
    $stmt->bind_param("s", $matricula);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $persona = $resultado->fetch_assoc();

        if ($persona['estado']) {
            $fecha = date("Y-m-d");
            $hora = date("H:i:s");

            // Buscar acceso del día SIN hora de salida
            $consulta = $conn->prepare("SELECT id FROM accesos WHERE matricula = ? AND fecha = ? AND hora_salida IS NULL");
            $consulta->bind_param("ss", $matricula, $fecha);
            $consulta->execute();
            $resultadoAcceso = $consulta->get_result();

            if ($tipo === 'entrada') {
                if ($resultadoAcceso->num_rows > 0) {
                    $_SESSION['mensaje'] = "Ya registraste ENTRADA hoy y no has salido";
                    $_SESSION['icono'] = "bi-exclamation-circle-fill";
                    $_SESSION['color'] = "orange";
                } else {
                    $insert = $conn->prepare("INSERT INTO accesos (matricula, fecha, hora_entrada) VALUES (?, ?, ?)");
                    $insert->bind_param("sss", $matricula, $fecha, $hora);
                    $insert->execute();

                    $_SESSION['mensaje'] = "{$persona['nombre']} {$persona['apellidos']}, ENTRADA REGISTRADA";
                    $_SESSION['detalle'] = "COMO: " . strtoupper($persona['tipo']) . "<br>CARRERA: " . strtoupper($persona['carrera'] ?? 'N/A');
                    $_SESSION['icono'] = "bi-box-arrow-in-right";
                    $_SESSION['color'] = "green";
                }
            } elseif ($tipo === 'salida') {
                if ($resultadoAcceso->num_rows === 0) {
                    $_SESSION['mensaje'] = "No tienes una ENTRADA registrada hoy";
                    $_SESSION['icono'] = "bi-exclamation-circle-fill";
                    $_SESSION['color'] = "orange";
                } else {
                    $registro = $resultadoAcceso->fetch_assoc();
                    $update = $conn->prepare("UPDATE accesos SET hora_salida = ? WHERE id = ?");
                    $update->bind_param("si", $hora, $registro['id']);
                    $update->execute();

                    $_SESSION['mensaje'] = "{$persona['nombre']} {$persona['apellidos']}, SALIDA REGISTRADA";
                    $_SESSION['detalle'] = "COMO: " . strtoupper($persona['tipo']) . "<br>CARRERA: " . strtoupper($persona['carrera'] ?? 'N/A');
                    $_SESSION['icono'] = "bi-box-arrow-right";
                    $_SESSION['color'] = "blue";
                }
            }
        } else {
            $_SESSION['mensaje'] = "Matrícula registrada pero INACTIVA";
            $_SESSION['icono'] = "bi-x-circle-fill";
            $_SESSION['color'] = "red";
        }
    } else {
        $_SESSION['mensaje'] = "Matrícula no válida";
        $_SESSION['icono'] = "bi-x-circle-fill";
        $_SESSION['color'] = "red";
    }

    $stmt->close();
    $conn->close();
    $baseURL = dirname(dirname($_SERVER['PHP_SELF']));
    header("Location: {$baseURL}/{$tipo}.php");

    exit;
}
