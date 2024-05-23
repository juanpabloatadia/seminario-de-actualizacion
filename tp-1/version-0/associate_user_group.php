<?php
require('include/config.php');
header('Content-Type:text/html;charset=UTF-8');
?>
<?php

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
  </head>
<body>
<  </form>
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





