<?php
header('Content-Type: application/json');
require_once 'db.php';
// Este archivo recoge los datos enviados desde el frontend, valida si coinciden con la bd y devuelve una respuesta

// Recoger datos enviados por AJAX
$data = json_decode(file_get_contents('php://input'), true);

// file_get_contents('php://input'): lee el cuerpo de la solicitud que se envió con AJAX
/* json_decode(): Convierte el contenido JSON recibido en un array asociativo de PHP.
    true asegura que se convierta en un array, en lugar de un objeto*/

$email = $data['email'];
$password = $data['password'];

try {

    $consulta = $pdo->prepare("SELECT * FROM usuarios WHERE id= :email");
    $consulta->bindParam(':email', $email);
    $consulta->execute();
    $user = $consulta->fetch(PDO::FETCH_ASSOC); //fetch(PDO::FETCH_ASSOC): Recupera el resultado de la consulta como un array asociativo. Si el usuario existe, obtendrás sus datos.

    if ($user && $user['password'] == $password) {
        // Iniciar sesión y redirigir
        session_start();
        error_reporting(E_ALL);
ini_set('display_errors', 1);
        $_SESSION['usuario'] = $user['nombre_usuario'];
        $_SESSION['email'] = $user['id'];
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
} catch (PDOException $e) {
   
    echo json_encode(['success' => false, 'error' => 'Error en la base de datos']);
}



