<?php
require('include/config.php');
header('Content-Type:text/html;charset=UTF-8');

// Obtener listas de usuarios y grupos de la base de datos
$users = [];
$groups = [];

try {
    // Obtener lista de usuarios
    $sql_users = "SELECT id, name FROM User";
    $stmt_users = $db->prepare($sql_users);
    $stmt_users->execute();
    $users = $stmt_users->fetchAll(PDO::FETCH_ASSOC);

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
    $id_user = $_POST['id_user'];
    $id_group = $_POST['id_group'];

    try {
        // Insertar datos en la tabla User_Group
        $sql = "INSERT INTO User_Group (id_user, id_group) VALUES (:id_user, :id_group)";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id_user', $id_user);
        $stmt->bindParam(':id_group', $id_group);
        $stmt->execute();

        echo "Usuario asociado al grupo correctamente";
    } catch (PDOException $e) {
        echo "Error al asociar usuario al grupo: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Asociar Usuario a Grupo</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <h2>Asociar Usuario a Grupo</h2>
  <form action="associate_user_group.php" method="post">
    <label for="id_user">Usuario:</label>
    <select id="id_user" name="id_user" required>
      <option value="">Seleccione un usuario</option>
      <?php foreach ($users as $user): ?>
        <option value="<?php echo $user['id']; ?>"><?php echo $user['name']; ?></option>
      <?php endforeach; ?>
    </select>

    <label for="id_group">Grupo:</label>
    <select id="id_group" name="id_group" required>
      <option value="">Seleccione un grupo</option>
      <?php foreach ($groups as $group): ?>
        <option value="<?php echo $group['id']; ?>"><?php echo $group['name']; ?></option>
      <?php endforeach; ?>
    </select>

    <button type="submit">Asociar Usuario a Grupo</button>
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







