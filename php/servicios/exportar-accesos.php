<?php
require_once '../lib/dompdf/autoload.inc.php';

use Dompdf\Dompdf;

$conexion = new mysqli("localhost", "root", "", "sistema-control");
$conexion->set_charset("utf8");

$errores = [];
$correoDestino = $_POST['correo'] ?? '';
$dias = isset($_POST['rango']) ? intval($_POST['rango']) : 1;
$fechaLimite = date('Y-m-d', strtotime("-" . ($dias - 1) . " days"));

$consulta = $conexion->prepare("
  SELECT a.matricula, p.nombre, p.apellidos, p.tipo, a.fecha, a.hora_entrada, a.hora_salida
  FROM accesos a
  LEFT JOIN personal p ON a.matricula = p.matricula
  WHERE a.fecha >= ?
  ORDER BY a.fecha DESC, a.hora_entrada DESC
");

$consulta->bind_param("s", $fechaLimite);
$consulta->execute();
$resultado = $consulta->get_result();

$registros = [];
$conteoTipos = [];

while ($fila = $resultado->fetch_assoc()) {
    $registros[] = $fila;
    $tipo = $fila['tipo'] ?? 'Desconocido';
    $conteoTipos[$tipo] = ($conteoTipos[$tipo] ?? 0) + 1;
}

$labels = array_keys($conteoTipos);
$datos = array_values($conteoTipos);
$chart_url = "https://quickchart.io/chart?c=" . urlencode(json_encode([
    'type' => 'pie',
    'data' => [
        'labels' => $labels,
        'datasets' => [['data' => $datos]]
    ]
    
]));

$nombreGraficaRel = '../../graficos/grafica_accesos.png';

if (!is_dir('../../graficos')) {
    mkdir('../../graficos', 0777, true);
}

file_put_contents($nombreGraficaRel, file_get_contents($chart_url));
$nombreGraficaAbs = realpath($nombreGraficaRel);



$html = '<h2 style="text-align:center;">Reporte de Accesos</h2>';

$html .= '<p>Rango: últimos ' . $dias . ' día(s) | Generado el: ' . date('Y-m-d H:i:s') . '</p>';

if ($nombreGraficaAbs && file_exists($nombreGraficaAbs)) {
    $imagenCodificada = base64_encode(file_get_contents($nombreGraficaAbs));
    $html .= '<img src="data:image/png;base64,' . $imagenCodificada . '" width="400" style="margin-bottom:20px;">';
} else {
    $html .= '<p style="color:red;">[No se pudo cargar la gráfica]</p>';
}




$html .= '<table border="1" cellpadding="5" cellspacing="0" width="100%">';
$html .= '<thead><tr><th>Matrícula</th><th>Nombre</th><th>Tipo</th><th>Fecha</th><th>Hora Entrada</th><th>Hora Salida</th></tr></thead><tbody>';
foreach ($registros as $fila) {
    $html .= '<tr>';
    $html .= '<td>' . htmlspecialchars($fila['matricula']) . '</td>';
    $html .= '<td>' . htmlspecialchars($fila['nombre'] . ' ' . $fila['apellidos']) . '</td>';
    $html .= '<td>' . htmlspecialchars($fila['tipo'] ?? 'Desconocido') . '</td>';

    $html .= '<td>' . htmlspecialchars($fila['fecha']) . '</td>';
    $html .= '<td>' . htmlspecialchars($fila['hora_entrada']) . '</td>';
    $html .= '<td>' . htmlspecialchars($fila['hora_salida']) . '</td>';
    $html .= '</tr>';
}
$html .= '</tbody></table>';

$dompdf = new Dompdf(['isRemoteEnabled' => true]);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();

$archivoPDF = $dompdf->output();
$nombreArchivo = "accesos_reporte.pdf";

if (isset($_POST['exportar'])) {
    header("Content-Type: application/pdf");
    header("Content-Disposition: attachment; filename=$nombreArchivo");
    echo $archivoPDF;
    exit;
}

if (isset($_POST['enviar']) && filter_var($correoDestino, FILTER_VALIDATE_EMAIL)) {
    $apiKey = require 'sendgrid-api-key.php';
    $contenido = base64_encode($archivoPDF);

    $emailData = [
        'personalizations' => [['to' => [['email' => $correoDestino]]]],
        'from' => ['email' => 'miguel.robledo58020@gmail.com', 'name' => 'Sistema de Control de Acceso'],
        'subject' => "Reporte de Accesos PDF",
        'content' => [[
            'type' => 'text/plain',
            'value' => "Adjunto se encuentra el reporte PDF con los accesos registrados."
        ]],
        'attachments' => [[
            'content' => $contenido,
            'type' => 'application/pdf',
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

    echo $status === 202
        ? "<script>alert('Correo enviado correctamente');</script>"
        : "<script>alert('Error al enviar correo. Código $status');</script>";
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Exportar Accesos</title>
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
                <li><a href="../accesos.php" class="activo"><i class="bi bi-bar-chart-line-fill"></i> Accesos</a></li>
                <li><a href="../../html/personal.html"><i class="bi bi-person-badge-fill"></i> Personal</a></li>
                <li><a href="../usuarios.php"><i class="bi bi-people-fill"></i> Usuarios</a></li>
            </ul>
        </nav>
    </aside>

    <main class="main-content">
        <header class="topbar d-flex justify-content-between align-items-center px-3">
            <div></div>
            <a href="logout.php" class="btn-salir">
                <i class="bi bi-box-arrow-right" style="margin-right: 6px;"></i> Cerrar Sesión
            </a>
        </header>

        <section class="contenido">
            <h2>Exportar registros de acceso</h2>

            <div class="formulario-container">
                <form method="POST">
                    <div class="form-group">
                        <label for="rango">Selecciona rango de días:</label>
                        <select id="rango" name="rango" required>
                            <option value="1">Último día</option>
                            <option value="3">Últimos 3 días</option>
                            <option value="7">Últimos 7 días</option>
                            <option value="30">Últimos 30 días</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="correo">Enviar PDF por correo (opcional):</label>
                        <input type="email" id="correo" name="correo" placeholder="ejemplo@correo.com">
                    </div>

                    <div class="botones-formulario">
                        <a href="../accesos.php" class="btn-cancelar">
                            <i class="bi bi-x-circle-fill" style="margin-right: 6px;"></i> Cancelar
                        </a>
                        <button type="submit" name="exportar" class="btn-aceptar">
                            <i class="bi bi-file-earmark-arrow-up" style="margin-right: 6px;"></i> Exportar PDF
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