<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['email']) || empty($_SESSION['email'])) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Usuario no autenticado']);
    exit;
}

$datos = json_decode(file_get_contents('php://input'), true);

header('Content-Type: application/json');

// Petición para añadir un prod
if (isset($datos['objeto']) && isset($datos['cantidad'])) {
    $objeto = $datos['objeto'];
    $cantidad = $datos['cantidad'];
    $email = $_SESSION['email'];

    try {
        // Insertar en la bd
        $consulta = $pdo->prepare("INSERT INTO compra (objeto, cantidad, id_comprador, fecha_hora) VALUES (:objeto, :cantidad, :email, NOW())");
        $consulta->bindParam(':objeto', $objeto);
        $consulta->bindParam(':cantidad', $cantidad);
        $consulta->bindParam(':email', $email);
        $consulta->execute();

        echo json_encode(['success' => true, 'message' => 'Producto añadido correctamente']);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error al añadir producto: ' . $e->getMessage()]);
    }
}

// 'id_compra', eliminar un prod
else if (isset($datos['id_compra'])) {
    $id_compra = $datos['id_compra'];

    try {
        // Eliminamos el prod de la bd
        $consulta = $pdo->prepare("DELETE FROM compra WHERE id_compra = :id_compra");
        $consulta->bindParam(':id_compra', $id_compra);
        $consulta->execute();

        echo json_encode(['success' => true, 'message' => 'Producto eliminado correctamente']);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error al eliminar producto: ' . $e->getMessage()]);
    }
}

// 'ultima_fecha', consulta prods nuevos!!
else if (isset($datos['ultima_fecha'])) {
    $ultima_fecha = $datos['ultima_fecha'];
    $email_actual = $_SESSION['email'];

    try {
        // Consultamos prods nuevos
        $consulta = $pdo->prepare("SELECT c.id_compra, c.objeto, c.cantidad, c.id_comprador, c.fecha_hora, u.nombre_usuario 
                                    FROM compra c 
                                    INNER JOIN usuarios u ON c.id_comprador = u.id 
                                    WHERE c.fecha_hora > :ultima_fecha 
                                    AND c.id_comprador != :email_actual
                                    ORDER BY c.fecha_hora DESC");
        $consulta->bindParam(':ultima_fecha', $ultima_fecha);
        $consulta->bindParam(':email_actual', $email_actual);
        $consulta->execute();

        $productos_nuevos = $consulta->fetchAll(PDO::FETCH_ASSOC);
        $fecha_actual = date('Y-m-d H:i:s');

        echo json_encode([
            'success' => true,
            'productos_nuevos' => $productos_nuevos,
            'fecha_actual' => $fecha_actual
        ]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error al consultar productos nuevos: ' . $e->getMessage()]);
    }
}

// Si no es ninguna, devolvemos todos los prods
else {
    try {
        $consulta = $pdo->prepare("SELECT c.id_compra, c.objeto, c.cantidad, c.id_comprador, c.fecha_hora, u.nombre_usuario 
                                    FROM compra c 
                                    INNER JOIN usuarios u ON c.id_comprador = u.id 
                                    ORDER BY c.fecha_hora DESC");
        $consulta->execute();

        $productos = $consulta->fetchAll(PDO::FETCH_ASSOC);

        // Devolvemos todos los prods
        echo json_encode(['success' => true, 'productos' => $productos]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error al consultar productos: ' . $e->getMessage()]);
    }
}