<?php 
    require_once __DIR__ . '/models/sistema.class.php';
    require_once __DIR__ . '/models/usuario/usuario.class.php';

    $app = new Sistema();
    $appUsuario = new Usuario();
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
                    $content = "Hola, para recuperar tu contraseña haz click en el siguiente enlace: <br>";
                    $content.= "<a href=HTTP://".$_SERVER['HTTP_HOST']."/admin/login.php?accion=recuperar_contrasena&token=$token>Recuperar contraseña</a>";
                    
                    if($appUsuario -> guardarToken($correo, $token)){
                        $app -> enviarCorreo([$correo], "Recuperar contraseña", $content);
                        $alerta = [
                            'mensaje' => 'Si existe la cuenta, se ha enviado un correo con las instrucciones para recuperar la contraseña',
                            'tipo' => 'success'
                        ];
                    } 
                } else {
                    $alerta = [
                        'mensaje' => 'Correo inválido',
                        'tipo' => 'danger'
                    ];
                }

            }
            require_once __DIR__ . '/../templates/login/login.html';
            break;
        
        case 'recuperar_contrasena':
            if(isset($_GET['token'])){
                $token = $_GET['token'];
                if(strlen($token) == 64){
                    if($appUsuario -> validarToken($token)){
                        require_once __DIR__ . '/../templates/login/_form_password.html';
                        exit();
                    } else {
                        $alerta = [
                            'mensaje' => 'Genera un nuevo enlace para recuperar tu contraseña',
                            'tipo' => 'danger'
                        ];
                    }
                }else{
                    $alerta = [
                        'mensaje' => 'Token inválido o expirado',
                        'tipo' => 'danger'
                    ];
                    require_once __DIR__ . '/../templates/login/login.html';
                }
            }
            break;   

        case 'restaurar_contrasena':
            if(isset($_POST['enviar'])){
                $token = $_POST['token'] ?? '';
                $contrasena = $_POST['contrasena1'] ?? '';
                $contrasena2 = $_POST['contrasena2'] ?? '';

                if($contrasena != '' && $contrasena2 != ''){
                    if($contrasena === $contrasena2){

                        if(strlen($token) == 64 && $appUsuario -> validarToken($token)){
                            $appUsuario -> actualizarContrasena($token, $contrasena);
                            $alerta = [
                                'mensaje' => 'Contraseña actualizada correctamente',
                                'tipo' => 'success'
                            ];
                            header('Location: login.php?accion=login');
                            exit();
                        } else {
                            $alerta = [
                                'mensaje' => 'Token inválido o expirado',
                                'tipo' => 'danger'
                            ];
                        }
                    } else {
                        $alerta = [
                            'mensaje' => 'Las contraseñas no coinciden',
                            'tipo' => 'danger'
                        ];
                    }
                } else {
                    $alerta = [
                        'mensaje' => 'Las contraseñas no coinciden o están vacías',
                        'tipo' => 'danger'
                    ];
                }
            }
            break;

        case 'login':
            default:
            require_once __DIR__ . '/../templates/login/login.html';
            break;
    }
?>