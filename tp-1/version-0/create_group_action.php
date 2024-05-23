<?php
require('include/config.php');
header('Content-Type:text/html;charset=UTF-8');
?>
<?php

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
  <title>Crear Grupo de Accion</title>
  </head>
<body>
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
