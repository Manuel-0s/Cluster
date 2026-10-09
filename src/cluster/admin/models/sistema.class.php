<?php
    require_once __DIR__.'/config.php';
    
    class Sistema {
        var $db;

        function __construct () {
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
    }
?>