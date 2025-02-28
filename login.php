<?php

require_once 'db.php';
// Este archivo recoge los datos enviados desde el frontend, valida si coinciden con la bd y devuelve una respuesta

// Recoger datos enviados por AJAX
$data = json_decode(file_get_contents('php://input'), true);

// file_get_contents('php://input'): lee el cuerpo de la solicitud que se envió con AJAX
/* json_decode(): Convierte el contenido JSON recibido en un array asociativo de PHP.
    true asegura que se convierta en un array, en lugar de un objeto*/

$email = $data['email'];
$password = $data['password'];

// Aquí iría la lógica para verificar los datos en la base de datos
/*
    Hacer una consulta SQL para verificar si el usuario
    existe y si la contraseña proporcionada es correcta. */
try {

    $consulta = $pdo->prepare("SELECT * FROM usuarios WHERE email= :email");
    $consulta->bindParam(':email', $email);
    $consulta->execute();
    $user = $consulta->fetch(PDO::FETCH_ASSOC); //fetch(PDO::FETCH_ASSOC): Recupera el resultado de la consulta como un array asociativo. Si el usuario existe, obtendrás sus datos.

    if ($user && $user['password'] == $password) {
        // Iniciar sesión y redirigir
        session_start();
        $_SESSION['usuario'] = $user['nombre_usuario'];
        $_SESSION['email'] = $user['id'];
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
} catch (PDOException $e) {
    // Si hay algún error en la consulta, lo manejamos
    echo json_encode(['success' => false, 'error' => 'Error en la base de datos']);
}


// Si el login es exitoso
if ($email == $user && $password == $pswd) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}
