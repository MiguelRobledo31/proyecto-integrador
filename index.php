<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Sistema de Control de Acceso</title>
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>

<body>
    <a href="php/admin.php" class="btn-volver">
        <i class="bi bi-person-fill-gear" style="margin-right: 6px;"></i> Admin
    </a>

    <div class="login-container">
        <h2 style="color: white; font-size: 22px; text-transform: uppercase; margin-bottom: 15px;">
            Sistema de Control<br>de Acceso
        </h2>
        <hr style="border: none; border-top: 1px solid #ffffff66; width: 80%; margin: 10px auto;">

        <img src="img/logo.png" alt="Logo" class="logo">

        <div class="login-form">
            <a href="#" onclick="abrirVentana('php/entrada.php')" class="boton-acceso">
                <i class="bi bi-box-arrow-in-right"></i> Entrada
            </a>

            <a href="#" onclick="abrirVentana('php/salida.php')" class="boton-acceso">
                <i class="bi bi-box-arrow-right"></i> Salida
            </a>

        </div>
    </div>

    <script>
        function abrirVentana(url) {
            window.open(url, '_blank', 'width=600,height=700,top=100,left=200');
        }
    </script>


</body>

</html>