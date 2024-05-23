<?php
require('include/config.php');
header('Content-Type:text/html;charset=UTF-8');

try {
    // Obtener usuarios de la base de datos con sus grupos y acciones correspondientes
    $sql = "SELECT DISTINCT User.*, Group.name AS group_name, Action.name AS action_name
            FROM User
            LEFT JOIN User_Group ON User.id = User_Group.id_user
            LEFT JOIN `Group` ON User_Group.id_group = `Group`.id
            LEFT JOIN Group_Action ON `Group`.id = Group_Action.id_group
            LEFT JOIN Action ON Group_Action.id_action = Action.id";
    $stmt = $db->query($sql);
    
    // Mostrar usuarios en una tabla
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>" . $row["id"] . "</td>";
        echo "<td>" . $row["name"] . "</td>";
        echo "<td>" . $row["email"] . "</td>";
        echo "<td>" . $row["group_name"] . "</td>";
        echo "<td>" . $row["action_name"] . "</td>";
        echo "<td><a href='edit_user.php?id=" . $row["id"] . "'><button type='submit'>Editar</button></form></td>"; // Agregar botón de edición
        echo "<form id='deleteForm" . $row["id"] . "' action='delete_user.php' method='POST' style='display:inline;'>";
        echo "<td><form action='delete_user.php' method='post'><input type='hidden' name='user_id' value='" . $row["id"] . "'><button type='submit'>Eliminar</button></form></td>"; // Botón de eliminar
        echo "</tr>";
    }
} catch (PDOException $e) {
    echo "Error al obtener usuarios: " . $e->getMessage();
}
?>
