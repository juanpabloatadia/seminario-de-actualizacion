<?php
require('include/config.php');
header('Content-Type: application/json');

session_start();

function hashPassword($password) {
    return password_hash($password, PASSWORD_BCRYPT);
}

function verifyPassword($password, $hashedPassword) {
    return password_verify($password, $hashedPassword);
}

function generateToken() {
    return bin2hex(random_bytes(16));
}

// Registro de usuario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'register') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $hashedPassword = hashPassword($password);

    try {
        $sql = "INSERT INTO User (name, email, password) VALUES (:name, :email, :password)";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->execute();

        echo json_encode(["message" => "Usuario registrado correctamente"]);
    } catch (PDOException $e) {
        echo json_encode(["error" => "Error al registrar usuario: " . $e->getMessage()]);
    }
}

// Inicio de sesión
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'login') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        $sql = "SELECT * FROM User WHERE email = :email";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && verifyPassword($password, $user['password'])) {
            $token = generateToken();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['token'] = $token;

            echo json_encode(["message" => "Inicio de sesión exitoso", "token" => $token]);
        } else {
            echo json_encode(["error" => "Credenciales inválidas"]);
        }
    } catch (PDOException $e) {
        echo json_encode(["error" => "Error al iniciar sesión: " . $e->getMessage()]);
    }
}

// Cerrar sesión
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'logout') {
    session_unset();
    session_destroy();
    echo json_encode(["message" => "Sesión cerrada correctamente"]);
}
?>
