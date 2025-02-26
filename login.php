<?php
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
    Por ejemplo, podrías hacer una consulta SQL para verificar si el usuario
    existe y si la contraseña proporcionada es correcta. */

// Si el login es exitoso
if ($email == $user && $password == $pswd) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}
