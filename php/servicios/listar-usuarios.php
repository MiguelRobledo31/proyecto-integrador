<?php
$conexion = new mysqli("localhost", "root", "", "sistema-control");
$conexion->set_charset("utf8");

$buscar = $_POST['buscar'] ?? '';
$limite = isset($_POST['limite']) ? intval($_POST['limite']) : 10;

$buscar = $conexion->real_escape_string($buscar);

$consulta = "SELECT * FROM usuarios 
             WHERE usuario LIKE '%$buscar%' 
             OR nombre LIKE '%$buscar%' 
             OR apellidos LIKE '%$buscar%' 
             OR rol LIKE '%$buscar%'
             ORDER BY id ASC 
             LIMIT $limite";

$resultado = $conexion->query($consulta);

if ($resultado->num_rows > 0):
  while ($fila = $resultado->fetch_assoc()):
?>
    <tr>
      <td><?= htmlspecialchars($fila['usuario']) ?></td>
      <td><?= htmlspecialchars($fila['password']) ?></td>
      <td><?= htmlspecialchars($fila['nombre']) ?></td>
      <td><?= htmlspecialchars($fila['apellidos']) ?></td>
      <td><?= htmlspecialchars($fila['rol']) ?></td>
      <td>
        <form method="POST" action="servicios/editar-usuario.php" style="display:inline;">
          <input type="hidden" name="id" value="<?= $fila['id'] ?>">
          <button class="btn-editar" title="Editar">
            <i class="bi bi-pencil-fill"></i>
          </button>
        </form>
        <form method="POST" action="servicios/eliminar-usuario.php" style="display:inline;" onsubmit="return confirm('¿Estás seguro de eliminar este usuario?');">
          <input type="hidden" name="id" value="<?= $fila['id'] ?>">
          <button class="btn-eliminar" title="Eliminar">
            <i class="bi bi-trash-fill"></i>
          </button>
        </form>
      </td>
    </tr>
<?php
  endwhile;
else:
?>
  <tr>
    <td colspan="6">No hay usuarios que coincidan.</td>
  </tr>
<?php
endif;
?>
