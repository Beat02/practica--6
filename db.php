<?php
$host = 'localhost';
$dbNombre = 'listacompra';
$username = 'root';
$password = '';

try {
    //Crear nueva PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Establecer el modo de error de PDO a excepciones
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
}
