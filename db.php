<?php
$host = 'localhost';
$dbNombre = 'listacompra';
$username = 'compra';
$password = '123456';

try {
    //Crear nueva PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbNombre", $username, $password);
    // Establecer el modo de error de PDO a excepciones
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
}
