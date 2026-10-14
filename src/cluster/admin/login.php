<?php 
    include_once __DIR__ . '/models/sistema.class.php';

    $app = new Sistema();
    $accion = $_GET['accion'] ?? 'login';
    
    switch ($accion) {
        case 'validar':
            if (isset($_POST['enviar'])) {
                $correo = $_POST['correo'] ?? '';
                $contrasena = $_POST['contrasena'] ?? '';

                if ($app -> login($correo, $contrasena)){
                    header('Location: index.php');
                    exit();
                }
            } 
            $alerta = [
                'mensaje' => 'Correo o contraseña incorrectos',
                'tipo' => 'danger'
            ];
            require_once __DIR__ . '/../templates/admin/alert.html';
            require_once __DIR__ . '/../templates/login/login.html';

            break;

        case 'logout':
            $app -> logout();
              $alerta = [
                'mensaje' => 'Sesión cerrada correctamente',
                'tipo' => 'success'
            ];
            require_once __DIR__ . '/../templates/admin/alert.html';
            require_once __DIR__ . '/../templates/login/login.html';

            exit();
            break;

        case 'login':
            default:
            require_once __DIR__ . '/../templates/login/login.html';
            break;
    }
?>