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
            require_once __DIR__ . '/../templates/login/login.html';

            break;

        case 'logout':
            $app -> logout();
              $alerta = [
                'mensaje' => 'Sesión cerrada correctamente',
                'tipo' => 'success'
            ];
            require_once __DIR__ . '/../templates/login/login.html';
            exit();
            break;
        case 'recuperar':
            include_once __DIR__ . '/../templates/login/_form_email.html';
            break;

        case 'enviar_correo':
            if (isset($_POST['enviar'])) {
                $correo = $_POST['correo'] ?? '';
                if (filter_var($correo, FILTER_VALIDATE_EMAIL)) {
                    $token = bin2hex(random_bytes(16));
                    $token = md5(md5($token).time()) . md5("Cruz Azul Campeaon Forever" . $correo);
                }
            }
            break;
                
        case 'login':
            default:
            require_once __DIR__ . '/../templates/login/login.html';
            break;
    }
?>