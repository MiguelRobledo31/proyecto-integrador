<?php
$conexion = new mysqli("localhost", "root", "", "sistema-control");
$conexion->set_charset("utf8");

$busqueda = $_GET['buscar'] ?? '';
$busqueda = $conexion->real_escape_string($busqueda);

$consulta = "SELECT * FROM usuarios 
             WHERE usuario LIKE '%$busqueda%' 
             OR nombre LIKE '%$busqueda%' 
             OR apellidos LIKE '%$busqueda%' 
             OR rol LIKE '%$busqueda%'
             ORDER BY id ASC";

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
        <form method="POST" action="../php/editar-usuario.php" style="display:inline;">
          <input type="hidden" name="id" value="<?= $fila['id'] ?>">
          <button class="btn-editar" title="Editar">
            <i class="bi bi-pencil-fill"></i>
          </button>
        </form>
        <form method="POST" action="../php/eliminar-usuario.php" style="display:inline;" onsubmit="return confirm('¿Estás seguro de eliminar este usuario?');">
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
    <td colspan="6">No hay usuarios registrados.</td>
  </tr>
<?php
endif;
?>