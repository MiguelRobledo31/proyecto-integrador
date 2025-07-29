<?php
$conexion = new mysqli("localhost", "root", "", "sistema-control");
$conexion->set_charset("utf8");

$tipo = $_GET['tipo'] ?? '';
$buscar = $_POST['buscar'] ?? '';
$limite = isset($_POST['limite']) ? intval($_POST['limite']) : 10;

$tipo = $conexion->real_escape_string(strtolower($tipo));
$buscar = $conexion->real_escape_string($buscar);

$sql = "SELECT * FROM personal WHERE tipo = '$tipo'";

if (!empty($buscar)) {
    $sql .= " AND (
        matricula LIKE '%$buscar%' OR 
        nombre LIKE '%$buscar%' OR 
        apellidos LIKE '%$buscar%' OR 
        carrera LIKE '%$buscar%'
    )";
}

$sql .= " ORDER BY apellidos ASC LIMIT $limite";

$resultado = $conexion->query($sql);

if ($resultado->num_rows > 0):
    while ($fila = $resultado->fetch_assoc()):
?>
<tr>
  <td><?= htmlspecialchars($fila['matricula']) ?></td>
  <td><?= htmlspecialchars($fila['nombre']) ?></td>
  <td><?= htmlspecialchars($fila['apellidos']) ?></td>
  <td><?= htmlspecialchars($fila['carrera']) ?></td>
  <td><?= $fila['estado'] ? 'Activo' : 'Inactivo' ?></td>
  <td>
<form action="servicios/editar-personal.php" method="POST" style="display: inline;">
  <input type="hidden" name="matricula" value="<?= $fila['matricula'] ?>">
  <input type="hidden" name="tipo" value="<?= htmlspecialchars($fila['tipo']) ?>">
  <button class="btn-editar" title="Editar"><i class="bi bi-pencil-square"></i></button>
</form>

<form action="servicios/eliminar-personal.php" method="POST" style="display: inline;" onsubmit="return confirm('¿Estás seguro de eliminar este registro?');">
  <input type="hidden" name="matricula" value="<?= $fila['matricula'] ?>">
  <input type="hidden" name="tipo" value="<?= htmlspecialchars($fila['tipo']) ?>">
  <button class="btn-eliminar" title="Eliminar"><i class="bi bi-trash-fill"></i></button>
</form>

  </td>
</tr>

<?php
    endwhile;
else:
?>
<tr>
  <td colspan="5">No hay registros que coincidan.</td>
</tr>
<?php endif; ?>
