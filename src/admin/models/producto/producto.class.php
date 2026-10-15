<?php
require_once __DIR__ . '/../sistema.class.php';

class Producto extends Sistema {
    function create($data) {
        if(!isset($data['producto'])){
            return ['error' => 'faltan datos requeridos'];
        }
        
        $datos = [];
        $data['foto'] = $this->cargarArchivo($nombre = 'foto', $ruta = '/../../images/uploads/');

        if (!is_null($data['foto'])){
            $sql = "INSERT INTO producto (producto, foto, precio, id_marca)
                    VALUES (:producto, :foto, :precio, :id_marca)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':producto', $data['producto'], PDO::PARAM_STR);
            $stmt->bindParam(':foto', $data['foto'], PDO::PARAM_STR);
            $stmt->bindParam(':precio', $data['precio'], PDO::PARAM_STR);
            $stmt->bindParam(':id_marca', $data['id_marca'], PDO::PARAM_STR);
            $stmt->execute();
            $datos = $data;
            $datos['afectados'] = $stmt->rowCount();
            $datos['id'] = $this->db->lastInsertId();
            return $datos;
        } else {
            return ['error' => 'debes seleccionar una foto válida'];
        }
    }

    function getOne($id) {
        $datos = [];
        if (is_numeric($id)) {
            $sql = "SELECT * FROM producto WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $datos = $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return $datos;
    }

    function getAll() {
        $datos = [];
        $sql = "SELECT p.id, p.producto, p.foto, p.precio, p.id_marca, m.marca
            FROM producto p
            JOIN marca m ON p.id_marca = m.id";
        $stmt = $this->db->query($sql);
        $datos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $datos;
    }

    function update($id, $data) {
        $nuevoLogo = $this->cargarArchivo($nombre = 'foto', $ruta = '/../../images/uploads/');

        if ($nuevoLogo !== null) {
            $data['foto'] = $nuevoLogo;
        } else {
            $productoActual = $this->getOne($id);
            $data['foto'] = $productoActual['foto'] ?? null;
        }

        $afectados = 0;
        if (is_numeric($id) && !empty($data)) {
            $sql = "UPDATE producto
                    SET producto = :producto,
                        foto = :foto,
                        precio = :precio,
                        id_marca = :id_marca
                    WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':producto', $data['producto'], PDO::PARAM_STR);
            $stmt->bindParam(':foto', $data['foto'], PDO::PARAM_STR);
            $stmt->bindParam(':precio', $data['precio'], PDO::PARAM_STR);
            $stmt->bindParam(':id_marca', $data['id_marca'], PDO::PARAM_INT);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            $afectados = $stmt->rowCount();
        }

        return $afectados;
    }

    function delete($id) {
        $afectados = 0;
        if (is_numeric($id)) {
            $sql = "DELETE FROM producto WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $afectados = $stmt->rowCount();
        }
        return $afectados;
    }
}
?>