<?php
$conexion = new mysqli("localhost", "root", "", "sistema-control");
$conexion->set_charset("utf8");

$tipo = $_GET['tipo'] ?? '';
$tipo = $conexion->real_escape_string(strtolower($tipo));

$consulta = "SELECT * FROM personal WHERE tipo = '$tipo' ORDER BY apellidos ASC";
$resultado = $conexion->query($consulta);

if ($resultado->num_rows > 0):
    while ($fila = $resultado->fetch_assoc()):
?>
<tr>
  <td><?= htmlspecialchars($fila['matricula']) ?></td>
  <td><?= htmlspecialchars($fila['nombre']) ?></td>
  <td><?= htmlspecialchars($fila['apellidos']) ?></td>
  <td><?= htmlspecialchars($fila['carrera']) ?></td>
  <td><?= $fila['estado'] ? 'Activo' : 'Inactivo' ?></td>
</tr>
<?php
    endwhile;
else:
?>
<tr>
  <td colspan="5">No hay registros para este tipo.</td>
</tr>
<?php endif; ?>
