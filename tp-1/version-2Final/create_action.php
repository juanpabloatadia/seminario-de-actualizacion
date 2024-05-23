<?php
require('include/config.php');
header('Content-Type:text/html;charset=UTF-8');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir datos del formulario
    $name = $_POST['name'];

    try {
        // Verificar si el grupo ya existe
        $sql_check = "SELECT COUNT(*) FROM Action WHERE name = :name";
        $stmt_check = $db->prepare($sql_check);
        $stmt_check->bindParam(':name', $name);
        $stmt_check->execute();
        $action_exists = $stmt_check->fetchColumn();

        if ($action_exists) {
            echo "La acción ya existe";
        } else {
            // Insertar datos en la base de datos
            $sql = "INSERT INTO Action (name) VALUES (:name)";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':name', $name);
            $stmt->execute();

            echo "Acción creada correctamente";
        }
    } catch (PDOException $e) {
        echo "Error al crear la acción: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Crear Acción</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <h2>Crear Nuevo Grupo</h2>
  <form action="create_action.php" method="post">
    <label for="name">Nombre de la Acción:</label>
    <input type="text" id="name" name="name" required>
    <button type="submit">Crear Acción</button>
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

