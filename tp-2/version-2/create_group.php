<?php
require('include/config.php');
header('Content-Type:text/html;charset=UTF-8');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir datos del formulario
    $name = $_POST['name'];

    try {
        // Verificar si el grupo ya existe
        $sql_check = "SELECT COUNT(*) FROM `Group` WHERE name = :name";
        $stmt_check = $db->prepare($sql_check);
        $stmt_check->bindParam(':name', $name);
        $stmt_check->execute();
        $group_exists = $stmt_check->fetchColumn();

        if ($group_exists) {
            echo "El grupo ya existe";
        } else {
            // Insertar datos en la base de datos
            $sql = "INSERT INTO `Group` (name) VALUES (:name)";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':name', $name);
            $stmt->execute();

            echo "Grupo creado correctamente";
        }
    } catch (PDOException $e) {
        echo "Error al crear grupo: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Crear Grupo</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <h2>Crear Nuevo Grupo</h2>
  <form action="create_group.php" method="post">
    <label for="name">Nombre del Grupo:</label>
    <input type="text" id="name" name="name" required>
    <button type="submit">Crear Grupo</button>
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

