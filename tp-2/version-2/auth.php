<?php
require('include/config.php');
header('Content-Type: application/json');

session_start();

// Cargar configuración
$config = json_decode(file_get_contents('config.json'), true);
$sessionMethod = $config['session_method'];

function hashPassword($password) {
    return password_hash($password, PASSWORD_BCRYPT);
}

function verifyPassword($password, $hashedPassword) {
    return password_verify($password, $hashedPassword);
}

function generateToken() {
    return bin2hex(random_bytes(16));
}

function getUserByEmail($db, $email) {
    $sql = "SELECT * FROM User WHERE email = :email";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
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
        $user = getUserByEmail($db, $email);

        if ($user && verifyPassword($password, $user['password'])) {
            if ($sessionMethod === 'token') {
                $token = generateToken();
                $sql = "UPDATE User SET token = :token WHERE id = :id";
                $stmt = $db->prepare($sql);
                $stmt->bindParam(':token', $token);
                $stmt->bindParam(':id', $user['id']);
                $stmt->execute();
                echo json_encode(["message" => "Inicio de sesión exitoso", "token" => $token]);
            } else {
                $_SESSION['user_id'] = $user['id'];
                echo json_encode(["message" => "Inicio de sesión exitoso"]);
            }
        } else {
            echo json_encode(["error" => "Credenciales inválidas"]);
        }
    } catch (PDOException $e) {
        echo json_encode(["error" => "Error al iniciar sesión: " . $e->getMessage()]);
    }
}

// Cerrar sesión
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'logout') {
    if ($sessionMethod === 'token') {
        $token = $_POST['token'];
        $sql = "UPDATE User SET token = NULL WHERE token = :token";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':token', $token);
        $stmt->execute();
    } else {
        session_unset();
        session_destroy();
    }
    echo json_encode(["message" => "Sesión cerrada correctamente"]);
}
?>
