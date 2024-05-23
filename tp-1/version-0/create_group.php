<?php
require('include/config.php');
header('Content-Type:text/html;charset=UTF-8');
?>
<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir datos del formulario
    $name = $_POST['name'];

    try {
        // Insertar datos en la base de datos
        $sql = "INSERT INTO `Group` (name) VALUES (:name)";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->execute();

        echo "Grupo creado correctamente";
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
