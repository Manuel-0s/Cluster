<?php
header('Content-Type: application/json; charset=utf-8');
require_once '../../models/marca/marca.class.php';

$app = new Marca();
$accion = $_SERVER['REQUEST_METHOD'];
$id = $_GET['id'] ?? null;
$datos = [];

switch ($accion) {
    case 'POST':
        if (isset($id) && is_numeric($id)) {
            $data = $_POST['data'];
            $datos['afectados'] = $app->update($id, $data);
            $datos = ['mensaje' => 'Marca actualizada correctamente'];
            $datos['registro'] = $app->getOne($id);
        } else {
            $data = $_POST['data'];
            $datos['afectados'] = $app->create($data);
            $datos = ['mensaje' => 'Marca creada correctamente'];
        }
        break;
    case 'DELETE':
        if (isset($id) && is_numeric($id)) {
            $datos['afectados'] = $app->delete($id);
            $datos = ['mensaje' => 'Marca eliminada correctamente'];
        }
        break;
    case 'GET':
    default:
        $datos = (isset($id) && is_numeric($id)) ? $app->getOne($id) : $app->getAll();
        break;
}

echo json_encode($datos, JSON_UNESCAPED_UNICODE);
?>