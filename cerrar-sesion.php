<?php
session_start();
// desmontar la sesión iniciada
session_unset();
session_destroy();

header('Content-Type: application/json');
echo json_encode(['success' => true, 'message' => 'Sesión cerrada correctamente']);
