<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User and Group Management</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <?php
  session_start();
  if (!isset($_SESSION['user_id'])) {
    header("Location: index.html");
    exit();
  }
  ?>
  
  <h1>Gestión de usuarios y grupos</h1>
  
  <!-- Botón de cierre de sesión -->
  <form action="logout.php" method="post">
    <button type="submit">Cerrar Sesión</button>
  </form>
  
  <!-- Lista de usuarios -->
  <h2>Lista de Usuarios</h2>
  <table border="1">
    <tr>
      <th>ID</th>
      <th>Nombre</th>
      <th>Email</th>
      <th>Grupo</th>
      <th>Acción</th>
      <th>Editar</th>
      <th>Eliminar</th>
    </tr>
    <?php include 'list_users.php'; ?>
  </table>

  <!-- Botón de retroceso -->
  <button onclick="goBack()">Actualizar</button>

  <script>
    // Función para ir hacia atrás y redirigir a index.php
    function goBack() {
      window.history.back();
      window.location.href = "index.php";
    }
    // Función para confirmar eliminación de usuario
    function confirmDelete(userId) {
      if (confirm("¿Está seguro de que desea eliminar este usuario?")) {
        document.getElementById('deleteForm' + userId).submit();
      }
    }
  </script>

  <!-- Formulario para crear un nuevo grupo -->
  <h2>Crear Nuevo Grupo</h2>
  <form action="create_group.php" method="post">
    <button type="submit">Crear Grupo</button>
  </form>

  <!-- Formulario para asociar usuario a grupo -->
  <h2>Asociar Usuario a Grupo</h2>
  <form action="associate_user_group.php" method="post">
    <button type="submit">Asociar Usuario a Grupo</button>
  </form>

  <!-- Formulario para crear una nueva acción -->
  <h2>Crear Nueva Acción</h2>
  <form action="create_action.php" method="post">
    <button type="submit">Crear Acción</button>
  </form>

  <!-- Formulario para asociar una acción a un grupo de usuarios -->
  <h2>Asociar Acción a Grupo de Usuarios</h2>
  <form action="create_group_action.php" method="post">
    <button type="submit">Asociar Acción a Grupo</button>
  </form>
</body>
</html>

