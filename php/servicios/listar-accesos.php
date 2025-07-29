<?php
include(__DIR__ . "/../conexion.php");

$limite = isset($_POST['limite']) ? (int)$_POST['limite'] : 10;
$buscar = isset($_POST['buscar']) ? $conn->real_escape_string($_POST['buscar']) : '';

$sql = "SELECT a.matricula, CONCAT(p.nombre, ' ', p.apellidos) AS nombre_completo,
               p.tipo, a.fecha, a.hora_entrada, a.hora_salida
        FROM accesos a
        JOIN personal p ON a.matricula = p.matricula";

if (!empty($buscar)) {
    $sql .= " WHERE a.matricula LIKE '%$buscar%' 
              OR p.nombre LIKE '%$buscar%' 
              OR p.apellidos LIKE '%$buscar%' 
              OR p.tipo LIKE '%$buscar%'";
}

$sql .= " ORDER BY fecha DESC, hora_entrada DESC LIMIT $limite";


$resultado = $conn->query($sql);
?>

<table>
  <thead>
    <tr>
      <th>Matrícula</th>
      <th>Nombre</th>
      <th>Tipo</th>
      <th>Fecha</th>
      <th>Hora de Entrada</th>
      <th>Hora de Salida</th>
    </tr>
  </thead>
  <tbody>
    <?php if ($resultado && $resultado->num_rows > 0): ?>
      <?php while ($row = $resultado->fetch_assoc()): ?>
        <tr>
          <td><?php echo htmlspecialchars($row['matricula']); ?></td>
          <td><?php echo htmlspecialchars($row['nombre_completo']); ?></td>
          <td><?php echo ucfirst(htmlspecialchars($row['tipo'])); ?></td>
          <td><?php echo htmlspecialchars($row['fecha']); ?></td>
          <td><?php echo htmlspecialchars($row['hora_entrada']); ?></td>
          <td><?php echo htmlspecialchars($row['hora_salida']); ?></td>
        </tr>
      <?php endwhile; ?>
    <?php else: ?>
      <tr><td colspan="6">No se encontraron registros.</td></tr>
    <?php endif; ?>
  </tbody>
</table>
