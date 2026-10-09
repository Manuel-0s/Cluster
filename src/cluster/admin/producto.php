<?php
    include_once __DIR__ . '/models/producto/producto.class.php';
    include_once __DIR__ . '/models/marca/marca.class.php';

    $appMarca = new Marca();
    $app = new Producto();
    $accion = $_GET['accion'] ?? 'read';
    $id = $_GET['id'] ?? null;

    include_once __DIR__ . '/../templates/admin/header.html';
    
    $marcas = $appMarca->getAll();

    switch ($accion) {
        case 'create':
            if (isset($_POST['enviar'])) {
                $data = $_POST['data'];
                $datos = $app->create($data);
                $productos = $app->getAll();
                include_once __DIR__ . '/../templates/admin/producto/index.html';
            } else {
                $datos = [];
                include_once __DIR__ . '/../templates/admin/producto/_form.php';
            }
            break;
        case 'update':
            if (isset($_POST['enviar'])) {
                $data = $_POST['data'];
                $id = $_POST['id'] ?? $_GET['id'] ?? null;
                $datos = $app->update($id, $data);
                $productos = $app->getAll();
                include_once __DIR__ . '/../templates/admin/producto/index.html';
            } else {
                $datos = $app->getOne($id);
                include_once __DIR__ . '/../templates/admin/producto/_form.php';
            }
            break;
        case 'delete':
            $afectados = $app->delete($id);
            $productos = $app->getAll();
            include_once __DIR__ . '/../templates/admin/producto/index.html';
            break;
        case 'read':
        default:
            $productos = $app->getAll();
            include_once __DIR__ . '/../templates/admin/producto/index.html';
            break;
    }

    include_once __DIR__ . '/../templates/admin/footer.html';
?>