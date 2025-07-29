<?php
$tipo = $_GET['tipo'] ?? '';
$tipoMostrar = ucfirst($tipo);
$conexion = new mysqli("localhost", "root", "", "sistema-control");
$conexion->set_charset("utf8");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $correoDestino = $_POST['correo'] ?? '';
    $tipo = $_GET['tipo'] ?? '';
    $tipoMostrar = ucfirst($tipo);

    $nombreArchivo = "{$tipo}_exportado.csv";
    $rutaTemporal = sys_get_temp_dir() . '/' . $nombreArchivo;

    $consulta = $conexion->prepare("SELECT matricula, nombre, apellidos, carrera, estado, foto FROM personal WHERE tipo = ?");
    $consulta->bind_param("s", $tipo);
    $consulta->execute();
    $resultado = $consulta->get_result();

    $archivo = fopen($rutaTemporal, 'w');
    fwrite($archivo, "\xEF\xBB\xBF");
    fputcsv($archivo, ['matricula', 'nombre', 'apellidos', 'carrera', 'estado', 'foto']);

    while ($fila = $resultado->fetch_assoc()) {
        fputcsv($archivo, $fila);
    }
    fclose($archivo);

    if (isset($_POST['enviar']) && filter_var($correoDestino, FILTER_VALIDATE_EMAIL)) {
        $apiKey = require 'sendgrid-api-key.php';
        $contenido = base64_encode(file_get_contents($rutaTemporal));

        $emailData = [
            'personalizations' => [['to' => [['email' => $correoDestino]]]],
            'from' => ['email' => 'miguel.robledo58020@gmail.com', 'name' => 'Sistema de Control de Acceso'],
            'subject' => "Exportación de $tipoMostrar",
            'content' => [['type' => 'text/plain', 'value' => "Adjunto se anexa el archivo CSV con los datos de <strong>$tipoMostrar</strong>."]],
            'attachments' => [[
                'content' => $contenido,
                'type' => 'text/csv',
                'filename' => $nombreArchivo
            ]]
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.sendgrid.com/v3/mail/send');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $apiKey,
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($emailData));

        $response = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($status === 202) {
            echo "<script>alert('Correo enviado correctamente a $correoDestino');</script>";
        } else {
            echo "<script>alert('Error al enviar correo. Código $status');</script>";
        }
    }

    if (isset($_POST['exportar'])) {
        header('Content-Type: text/csv; charset=utf-8');
        header("Content-Disposition: attachment; filename={$nombreArchivo}");
        readfile($rutaTemporal);
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <title>Exportar <?= $tipoMostrar ?></title>
    <link rel="stylesheet" href="../../css/sistema.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>

<body>
    <aside class="sidebar">
        <img src="../../img/logo.png" alt="UPTex" class="logo-sidebar" />
        <nav>
            <ul>
                <li><a href="../../index.php"><i class="bi bi-house-door-fill"></i> Control de Acceso</a></li>
                <br><br>
                <li><a href="../accesos.php"><i class="bi bi-bar-chart-line-fill"></i> Accesos</a></li>
                <li><a href="../../html/personal.html" class="activo"><i class="bi bi-person-badge-fill"></i> Personal</a></li>
                <li><a href="../usuarios.php"><i class="bi bi-people-fill"></i> Usuarios</a></li>
            </ul>
        </nav>
    </aside>

    <main class="main-content">
        <header class="topbar d-flex justify-content-between align-items-center px-3">
            <div></div>
            <a href="./logout.php" class="btn-salir">
                <i class="bi bi-box-arrow-right" style="margin-right: 6px;"></i> Cerrar Sesión
            </a>
        </header>

        <section class="contenido">
            <h2>Exportar registros de <?= $tipoMostrar ?></h2>

            <div class="formulario-container">
                <form method="POST">
                    <div class="form-group">
                        <label for="correo">Enviar CSV por correo (opcional):</label>
                        <input type="email" id="correo" name="correo" placeholder="ejemplo@correo.com">
                    </div>


                    <div class="botones-formulario">
                        <a href="../tipo-personal.php?tipo=<?= urlencode($tipo) ?>" class="btn-cancelar">
                            <i class="bi bi-x-circle-fill" style="margin-right: 6px;"></i> Cancelar
                        </a>
                        <button type="submit" name="exportar" class="btn-aceptar">
                            <i class="bi bi-upload" style="margin-right: 6px;"></i> Exportar CSV
                        </button>
                        <button type="submit" name="enviar" class="btn-aceptar">
                            <i class="bi bi-send" style="margin-right: 6px;"></i> Enviar por correo
                        </button>
                    </div>

                </form>
            </div>
        </section>
    </main>
</body>

</html>