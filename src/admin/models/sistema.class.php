<?php
    require_once __DIR__.'/config.php';
    
    class Sistema {
        var $db;

        function __construct () {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $this->db = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
        }

        function cargarArchivo($nombre, $ruta){
            $foto = $_FILES['data'];
            
            if (!isset($foto['name'][$nombre]) || $foto['error'][$nombre] !== UPLOAD_ERR_OK) {
                return null;
            }

            $data['nombre'] = $foto['name'][$nombre];

            $tipos = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/bmp'];
            $extensiones = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg', 'pdf', 'txt', 'doc', 'docx'];

            if (!in_array($foto['type'][$nombre], $tipos)){
                return null;
            }

            $extension = strtolower(pathinfo($data['nombre'], PATHINFO_EXTENSION));
            if (!in_array($extension, $extensiones)){
                return null;
            }

            $tamanoMaximo = 2 * 1024 * 1024; 
            if($foto['size'][$nombre] > $tamanoMaximo){
                return null;
            }

            $nuevoNombre = md5('cruzAzulCampeon' . $data['nombre'] . time());
            $nuevoNombre = $nuevoNombre . '.' . $extension;

            if(move_uploaded_file($foto['tmp_name'][$nombre], __DIR__ . $ruta . $nuevoNombre)){
                return $nuevoNombre; 
            }
            
            return null;
        }

        function login($correo, $contrasena) {
            if (filter_var($correo, FILTER_VALIDATE_EMAIL)) {

                $sql = "SELECT * FROM usuario WHERE correo = :correo";
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
                $stmt->execute();
                $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($usuario && password_verify($contrasena, $usuario['contrasena'])) {
                    session_regenerate_id(true);
                    unset($usuario['contrasena']);

                    $_SESSION['usuario'] = $usuario;
                    $_SESSION['id_usuario'] = $usuario['id_usuario'];
                    $_SESSION['valido'] = true;
                    $_SESSION['roles'] = $this->getRoles($usuario['correo']);
                    $_SESSION['permisos'] = $this->getPermisos($usuario['correo']);
                    return true;
                }
            }
            $this->logout();
            return false;
        }

        function logout(){
            unset($_SESSION['usuario']);
            unset($_SESSION['id_usuario']);
            unset($_SESSION['valido']);
            unset($_SESSION['roles']);
            unset($_SESSION['permisos']);
            session_destroy();
        }

        function getRoles($correo){
            $sql = "SELECT r.rol FROM rol r
                JOIN usuario_rol ur ON r.id_rol = ur.id_rol
                JOIN usuario u ON ur.id_usuario = u.id_usuario
                WHERE u.correo = :correo";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':correo', $correo);
            $stmt->execute();
            $roles = $stmt->fetchAll(PDO::FETCH_COLUMN);
            foreach ($roles as $rol) {
                $_SESSION['roles'][] = $rol;
            }
            return $roles;
        }

        function getPermisos($correo){
            $sql = "SELECT r.rol FROM rol r
                JOIN usuario_rol ur ON r.id_rol = ur.id_rol
                JOIN usuario u ON ur.id_usuario = u.id_usuario
                JOIN rol_permiso rp ON r.id_rol = rp.id_rol
                JOIN permiso p ON rp.id_permiso = p.id_permiso
                WHERE u.correo = :correo";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':correo', $correo);
            $stmt->execute();
            $permisos = $stmt->fetchAll(PDO::FETCH_COLUMN);
            foreach ($permisos as $permiso) {
                $_SESSION['permisos'][] = $permiso;
            }
            return $permisos;
        }

        function checarRol($rol){
            if (isset($_SESSION['roles']) && in_array($rol, $_SESSION['roles'])){
                return true;
            }
            $alerta = [
                'mensaje' => 'No tienes permiso para acceder a esta sección, vuelvete a logear',
                'tipo' => 'danger'
            ];
            $this -> logout();
            require_once __DIR__ . '/../templates/login/login.html';
            return exit();            
        }
    }
?>