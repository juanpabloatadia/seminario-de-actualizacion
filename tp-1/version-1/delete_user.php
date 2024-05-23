<?php
require('include/config.php');
header('Content-Type:text/html;charset=UTF-8');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener el ID del usuario a eliminar
    $user_id = $_POST['user_id'];

    try {
        // Eliminar las asociaciones del usuario en User_Group
        $sql = "DELETE FROM User_Group WHERE id_user = :user_id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();

        // Luego, eliminar el usuario de la tabla User
        $sql = "DELETE FROM User WHERE id = :user_id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();

        // Redireccionar de nuevo a index.php después de la eliminación
        header('Location: index.php');
        exit();
    } catch (PDOException $e) {
        echo "Error al eliminar usuario: " . $e->getMessage();
    }
}
?>

