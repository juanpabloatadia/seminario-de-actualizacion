<?php
require('include/config.php');
header('Content-Type:text/html;charset=UTF-8');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir datos del formulario
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        // Verificar si el usuario ya existe
        $sql_check = "SELECT COUNT(*) FROM User WHERE name = :name";
        $stmt_check = $db->prepare($sql_check);
        $stmt_check->bindParam(':name', $name);
        $stmt_check->execute();
        $user_exists = $stmt_check->fetchColumn();

        if ($user_exists) {
            echo "El usuario ya existe";
        } else {
            // Insertar datos en la base de datos
            $sql = "INSERT INTO User (name, email, password) VALUES (:name, :email, :password)";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password);
            $stmt->execute();

            echo "Usuario creado correctamente";
        }
    } catch (PDOException $e) {
        echo "Error al crear usuario: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Crear Usuario</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <h2>Crear Nuevo Usuario</h2>
  <form action="create_user.php" method="post">
    <label for="name">Nombre:</label>
    <input type="text" id="name" name="name" required>
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>
    <label for="password">Contraseña:</label>
    <input type="password" id="password" name="password" required>
    <button type="submit">Crear Usuario</button>
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


