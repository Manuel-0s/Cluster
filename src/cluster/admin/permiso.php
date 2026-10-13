<?php
    include_once __DIR__ . '/models/permisos/permiso.class.php';

    $app = new Permiso();
    $accion = $_GET['accion'] ?? 'read';
    $id = $_GET['id'] ?? null;

    include_once __DIR__ . '/../templates/admin/header.html';
    
    switch ($accion) {
        case 'create':
            if (isset($_POST['enviar'])) {
                $data = $_POST['data'];
                $datos = $app->create($data);
                $permisos = $app->getAll();
                include_once __DIR__ . '/../templates/admin/permiso/index.html';
            } else {
                $datos = [];
                include_once __DIR__ . '/../templates/admin/permiso/_form.php';
            }
            break;
        case 'update':
            if (isset($_POST['enviar'])) {
                $data = $_POST['data'];
                $id = $_POST['id'] ?? $_GET['id'] ?? null;
                $datos = $app->update($id, $data);
                $permisos = $app->getAll();
                include_once __DIR__ . '/../templates/admin/permiso/index.html';
            } else {
                $datos = $app->getOne($id);
                include_once __DIR__ . '/../templates/admin/permiso/_form.php';
            }
            break;
        case 'delete':
            $afectados = $app->delete($id);
            $permisos = $app->getAll();
            include_once __DIR__ . '/../templates/admin/permiso/index.html';
            break;
        case 'read':
        default:
            $permisos = $app->getAll();
            include_once __DIR__ . '/../templates/admin/permiso/index.html';
            break;
    }

    include_once __DIR__ . '/../templates/admin/footer.html';
?>