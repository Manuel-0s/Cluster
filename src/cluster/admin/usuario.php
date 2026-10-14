<?php
    include_once __DIR__ . '/models/usuario/usuario.class.php';
    include_once __DIR__ . '/models/rol/rol.class.php';

    $app = new Usuario();
    $rolApp = new Rol();
    $app -> checarRol("Administrador");
    $accion = $_GET['accion'] ?? 'read';
    $id = $_GET['id'] ?? null;

    include_once __DIR__ . '/../templates/admin/header.html';

    switch ($accion) {
        case 'create':
            if (isset($_POST['enviar'])) {
                $data = $_POST['data'];
                $data['contrasena'] = md5($data['contrasena']);
                $datos = $app->create($data);
                $usuarios = $app->getAll();
                include_once __DIR__ . '/../templates/admin/usuario/index.html';
            } else {
                $datos = [];
                include_once __DIR__ . '/../templates/admin/usuario/_form.php';
            }
            break;
        case 'update':
            if (isset($_POST['enviar'])) {
                $data = $_POST['data'];

                if (!empty($data['contrasena'])) {
                    $data['contrasena'] = md5($data['contrasena']);
                } else {
                    unset($data['contrasena']);
                }

                $id = $_POST['id'] ?? $_GET['id'] ?? null;
                $datos = $app->update($id, $data);
                $usuarios = $app->getAll();
                include_once __DIR__ . '/../templates/admin/usuario/index.html';
            } else {
                $datos = $app->getOne($id);
                $roles = $rolApp->getAll();
                include_once __DIR__ . '/../templates/admin/usuario/_form.php';
            }
            break;
        case 'delete':
            $afectados = $app->delete($id);
            $usuarios = $app->getAll();
            include_once __DIR__ . '/../templates/admin/usuario/index.html';
            break;
        case 'read':
        default:
            $usuarios = $app->getAll();
            include_once __DIR__ . '/../templates/admin/usuario/index.html';
            break;
    }

    include_once __DIR__ . '/../templates/admin/footer.html';
?>