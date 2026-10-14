<?php
    include_once __DIR__ . '/models/marca/marca.class.php';
    include_once __DIR__ . '/models/proveedor/proveedor.class.php';

    $appProveedor = new Proveedor(); 
    $app = new Marca();
    $app -> checarRol("Administrador");
    $accion = $_GET['accion'] ?? 'read';
    $id = $_GET['id'] ?? null;

    include_once __DIR__ . '/../templates/admin/header.html';

    $proveedores = $appProveedor->getAll();

    switch ($accion) {
        case 'create':
            if (isset($_POST['enviar'])) {
                $data = $_POST['data'];
                $datos = $app->create($data);
                $marcas = $app->getAll();
                include_once __DIR__ . '/../templates/admin/marca/index.html';
            } else {
                $datos = [];
                include_once __DIR__ . '/../templates/admin/marca/_form.php';
            }
            break;
        case 'update':
            if (isset($_POST['enviar'])) {
                $data = $_POST['data'];
                $id = $_POST['id'] ?? $_GET['id'] ?? null;
                $datos = $app->update($id, $data);
                $marcas = $app->getAll();
                include_once __DIR__ . '/../templates/admin/marca/index.html';
            } else {
                $datos = $app->getOne($id);
                include_once __DIR__ . '/../templates/admin/marca/_form.php';
            }
            break;
        case 'delete':
            $afectados = $app->delete($id);
            $marcas = $app->getAll();
            include_once __DIR__ . '/../templates/admin/marca/index.html';
            break;
        case 'read':
        default:
            $marcas = $app->getAll();
            include_once __DIR__ . '/../templates/admin/marca/index.html';
            break;
    }

    include_once __DIR__ . '/../templates/admin/footer.html';
?>