<?php
require('include/config.php');
session_start();

$config = json_decode(file_get_contents('config.json'), true);
$sessionMethod = $config['session_method'];

if ($sessionMethod === 'token') {
    if (isset($_POST['token'])) {
        $token = $_POST['token'];
        $sql = "UPDATE User SET token = NULL WHERE token = :token";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':token', $token);
        $stmt->execute();
    }
} else {
    session_unset();
    session_destroy();
}

header("Location: index.html");
exit();
?>

