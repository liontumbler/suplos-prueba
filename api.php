<?php
require 'db.php';
require 'exportar.php';
header('Content-Type: application/json');

$database = new Database();
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        $res = $database->crearOferta($data['objeto'], $data['actividad'], $data['descripcion'], $data['moneda'], $data['presupuesto']);
        if ($res) {
            echo json_encode(['message' => 'Oferta creada correctamente']);
        } else {
            echo json_encode(['message' => 'Error al crear la oferta']);
        }
        break;
    
    case 'GET':
        if (isset($_GET['id']) || isset($_GET['objeto']) || isset($_GET['comprador']) || isset($_GET['estado'])) {
            $oferta = $database->obtenerOferta($_GET['id'], $_GET['objeto'], $_GET['comprador'], $_GET['estado']);
            echo json_encode($oferta ? $oferta : ['message' => 'Oferta no encontrada']);
        } else {
            echo json_encode($database->obtenerOfertas());
        }
        break;
    
    case 'PUT':
        $data = json_decode(file_get_contents('php://input'), true);
        if (isset($_GET['id']) && $database->actualizarOferta($_GET['id'], $data['estado'])) {
            echo json_encode(['message' => 'Oferta actualizada correctamente']);
        } else {
            echo json_encode(['message' => 'Error al actualizar la oferta']);
        }
        break;
    
    case 'DELETE':
        if (isset($_GET['id']) && $database->eliminarOferta($_GET['id'])) {
            echo json_encode(['message' => 'Oferta eliminada correctamente']);
        } else {
            echo json_encode(['message' => 'Error al eliminar la oferta']);
        }
        break;

    case 'OPTIONS':
        $data = json_decode(file_get_contents('php://input'), true);

        if (!isset($data['data'])) {
            echo json_encode(['message' => 'No se enviaron datos válidos']);
            exit;
        }
        exportarExcel($data['data']);
        break;
    
    default:
        echo json_encode(['message' => 'Método no permitido']);
        break;
}
?>