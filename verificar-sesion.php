<?php
session_start();

// Comprobar si existe la sesión de usuario
if (isset($_SESSION['email']) && !empty($_SESSION['email'])) {
    // El usuario tiene sesión activa
    echo json_encode([
        'autenticado' => true,
        'usuario' => $_SESSION['usuario'],
        'email' => $_SESSION['email']
    ]);
} else {
    // No hay sesión activa
    echo json_encode(['autenticado' => false]);
}
