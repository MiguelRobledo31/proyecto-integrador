<?php
session_start();
date_default_timezone_set('America/Mexico_City');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $matricula = trim($_POST['matricula']);

    if (empty($matricula)) {
        $_SESSION['mensaje'] = "Matrícula vacía";
        $_SESSION['icono'] = "✖";
        $_SESSION['color'] = "red";
        header("Location: ../../index.php");
        exit;
    }

    $conn = new mysqli("localhost", "root", "", "sistema-control");

    if ($conn->connect_error) {
        $_SESSION['mensaje'] = "Error de conexión con la base de datos";
        $_SESSION['icono'] = "✖";
        $_SESSION['color'] = "red";
        header("Location: ../../index.php");
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

            $consulta = $conn->prepare("SELECT id FROM accesos WHERE matricula = ? AND fecha = ? AND hora_salida IS NULL");
            $consulta->bind_param("ss", $matricula, $fecha);
            $consulta->execute();
            $resultadoAcceso = $consulta->get_result();

            if ($resultadoAcceso->num_rows > 0) {
                $registro = $resultadoAcceso->fetch_assoc();
                $update = $conn->prepare("UPDATE accesos SET hora_salida = ? WHERE id = ?");
                $update->bind_param("si", $hora, $registro['id']);
                $update->execute();

                $_SESSION['mensaje'] = "{$persona['nombre']} {$persona['apellidos']}, REGISTRO DE SALIDA";
                $_SESSION['detalle'] = "COMO: " . strtoupper($persona['tipo']) . "<br>CARRERA: " . strtoupper($persona['carrera'] ?? 'N/A');
                $_SESSION['icono'] = "⇨";
                $_SESSION['color'] = "blue";
            } else {
                $insert = $conn->prepare("INSERT INTO accesos (matricula, fecha, hora_entrada) VALUES (?, ?, ?)");
                $insert->bind_param("sss", $matricula, $fecha, $hora);
                $insert->execute();

                $_SESSION['mensaje'] = "{$persona['nombre']} {$persona['apellidos']}, estás ACTIVO";
                $_SESSION['detalle'] = "COMO: " . strtoupper($persona['tipo']) . "<br>CARRERA: " . strtoupper($persona['carrera'] ?? 'N/A');
                $_SESSION['icono'] = "✓";
                $_SESSION['color'] = "green";
            }
        } else {
            $_SESSION['mensaje'] = "Matrícula registrada pero INACTIVA";
            $_SESSION['icono'] = "✖";
            $_SESSION['color'] = "red";
        }
    } else {
        $_SESSION['mensaje'] = "Matrícula no válida";
        $_SESSION['icono'] = "✖";
        $_SESSION['color'] = "red";
    }

    $stmt->close();
    $conn->close();
    header("Location: ../../index.php");
    exit;
}
