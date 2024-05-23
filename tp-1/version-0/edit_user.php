<?php
require('include/config.php');
header('Content-Type:text/html;charset=UTF-8');

// Verificar si se recibió un ID de usuario válido
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "ID de usuario no válido";
    exit;
}

// Obtener el ID de usuario de la URL
$user_id = $_GET['id'];

// Obtener los detalles del usuario a partir de su ID
try {
    $sql = "SELECT User.*, Group.id AS group_id, Group.name AS group_name, Action.id AS action_id, Action.name AS action_name
            FROM User
            LEFT JOIN User_Group ON User.id = User_Group.id_user
            LEFT JOIN `Group` ON User_Group.id_group = `Group`.id
            LEFT JOIN Group_Action ON `Group`.id = Group_Action.id_group
            LEFT JOIN Action ON Group_Action.id_action = Action.id
            WHERE User.id = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $user_id);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error al obtener detalles del usuario: " . $e->getMessage();
    exit;
}

// Obtener todos los grupos disponibles
try {
    $sql = "SELECT * FROM `Group`";
    $stmt = $db->query($sql);
    $groups = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error al obtener grupos: " . $e->getMessage();
    exit;
}

// Obtener todas las acciones disponibles
try {
    $sql = "SELECT * FROM Action";
    $stmt = $db->query($sql);
    $actions = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error al obtener acciones: " . $e->getMessage();
    exit;
}

// Verificar si el formulario de edición ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir datos del formulario
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $group_id = $_POST['group'];
    $action_id = $_POST['action'];

    try {
        // Actualizar los datos del usuario en la base de datos
        $sql = "UPDATE User SET name = :name, email = :email, password = :password WHERE id = :id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':id', $user_id);
        $stmt->execute();

        // Actualizar la asociación del usuario con el grupo en la tabla User_Group
        $sql = "UPDATE User_Group SET id_group = :group_id WHERE id_user = :user_id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':group_id', $group_id);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();

        // Actualizar la asociación del grupo con la acción en la tabla Group_Action
        $sql = "UPDATE Group_Action SET id_action = :action_id WHERE id_group = :group_id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':action_id', $action_id);
        $stmt->bindParam(':group_id', $group_id);
        $stmt->execute();

        echo "Usuario actualizado correctamente";
    } catch (PDOException $e) {
        echo "Error al actualizar usuario: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar Usuario</title>
</head>
<body>
  <h1>Editar Usuario</h1>

  <form action="" method="post">
    <label for="name">Nombre:</label>
    <input type="text" id="name" name="name" value="<?php echo $user['name']; ?>" required>
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>" required>
    <label for="password">Contraseña:</label>
    <input type="password" id="password" name="password" value="<?php echo $user['password']; ?>" required>

    <label for="group">Grupo:</label>
    <select id="group" name="group">
        <?php foreach ($groups as $group): ?>
            <option value="<?php echo $group['id']; ?>" <?php echo ($group['id'] == $user['group_id']) ? 'selected' : ''; ?>><?php echo $group['name']; ?></option>
        <?php endforeach; ?>
    </select>

    <label for="action">Acción:</label>
    <select id="action" name="action">
        <?php foreach ($actions as $action): ?>
            <option value="<?php echo $action['id']; ?>" <?php echo ($action['id'] == $user['action_id']) ? 'selected' : ''; ?>><?php echo $action['name']; ?></option>
        <?php endforeach; ?>
    </select>

    <button type="submit">Actualizar Usuario</button>
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
</body>
</html>

