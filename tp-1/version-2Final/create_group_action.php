<?php
require('include/config.php');
header('Content-Type:text/html;charset=UTF-8');

// Obtener listas de acciones y grupos de la base de datos
$actions = [];
$groups = [];

try {
    // Obtener lista de acciones
    $sql_actions = "SELECT id, name FROM Action";
    $stmt_actions = $db->prepare($sql_actions);
    $stmt_actions->execute();
    $actions = $stmt_actions->fetchAll(PDO::FETCH_ASSOC);

    // Obtener lista de grupos
    $sql_groups = "SELECT id, name FROM `Group`";
    $stmt_groups = $db->prepare($sql_groups);
    $stmt_groups->execute();
    $groups = $stmt_groups->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error al obtener datos: " . $e->getMessage();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir datos del formulario
    $id_group = $_POST['id_group'];
    $id_action = $_POST['id_action'];

    try {
        // Insertar datos en la base de datos
        $sql = "INSERT INTO Group_Action (id_group, id_action) VALUES (:id_group, :id_action)";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id_group', $id_group);
        $stmt->bindParam(':id_action', $id_action);
        $stmt->execute();

        echo "Asociación de acción y grupo de usuario creada correctamente";
    } catch (PDOException $e) {
        echo "Error al asociar acción y grupo de usuario: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Crear Asociación de Acción y Grupo</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <h2>Asociar Acción a Grupo de Usuarios</h2>
  <form action="create_group_action.php" method="post">
    <label for="id_group">Grupo:</label>
    <select id="id_group" name="id_group" required>
      <option value="">Seleccione un grupo</option>
      <?php foreach ($groups as $group): ?>
        <option value="<?php echo $group['id']; ?>"><?php echo $group['name']; ?></option>
      <?php endforeach; ?>
    </select>

    <label for="id_action">Acción:</label>
    <select id="id_action" name="id_action" required>
      <option value="">Seleccione una acción</option>
      <?php foreach ($actions as $action): ?>
        <option value="<?php echo $action['id']; ?>"><?php echo $action['name']; ?></option>
      <?php endforeach; ?>
    </select>

    <button type="submit">Asociar Acción a Grupo</button>
  </form>

  <!-- Botón de retroceso -->
  <button onclick="goBack()">Volver Atrás</button>

  <script>
    // Función para ir hacia atrás y redirigir a index.php
    function goBack() {
      window.history.back();
      window.location.href = "index.php";
    }
  </script>
</body>
</html>
