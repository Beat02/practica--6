<?php
session_start();

if (isset($_SESSION['email']) && !empty($_SESSION['email'])) {
    // Sesión activa
    echo json_encode([
        'autenticado' => true,
        'usuario' => $_SESSION['usuario'],
        'email' => $_SESSION['email']
    ]);
} else {
    // No hay sesión activa
    echo json_encode(['autenticado' => false]);
}
