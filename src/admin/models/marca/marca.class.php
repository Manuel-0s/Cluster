<?php
require_once __DIR__ . '/../sistema.class.php';

class Marca extends Sistema {
    function create($data) {
        if(!isset($data['marca'])){
            return ['error' => 'faltan datos requeridos'];
        }
        $datos = [];
        $data['logo'] = $this -> cargarArchivo($nombre = 'logo', $ruta = '/../../images/uploads/');

        if (!is_null($data['logo'])) {
            $sql = "INSERT INTO marca (marca, logo, id_proveedor)
                    VALUES (:marca, :logo, :id_proveedor)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':marca', $data['marca'], PDO::PARAM_STR);
            $stmt->bindParam(':logo', $data['logo'], PDO::PARAM_STR);
            $stmt->bindParam(':id_proveedor', $data['id_proveedor'], PDO::PARAM_INT);
            $stmt->execute();
            $datos = $data;
            $datos['afectados'] = $stmt->rowCount();
            $datos['id'] = $this->db->lastInsertId();
        } else {            
            return $datos;
        }
    }

    function getOne($id) {
        $datos = [];
        if (is_numeric($id)) {
            $sql = "SELECT * FROM marca WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $datos = $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return $datos;
    }

    function getAll() {
        $datos = [];
        $sql = "SELECT m.*, p.razon_social, p.rfc FROM marca m
                    JOIN proveedor p ON m.id_proveedor = p.id;";
        $stmt = $this->db->query($sql);
        $datos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $datos;
    }

    function update($id, $data) {
        $nuevoLogo = $this->cargarArchivo($nombre = 'logo', $ruta = '/../../images/uploads/');

        if ($nuevoLogo !== null) {
            $data['logo'] = $nuevoLogo;
        } else {
            $marcaActual = $this->getOne($id);
            $data['logo'] = $marcaActual['logo'] ?? null;
        }

        $afectados = 0;
        if (is_numeric($id) && !empty($data)) {
            $sql = "UPDATE marca
                    SET marca = :marca,
                        logo = :logo,
                        id_proveedor = :id_proveedor
                    WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':marca', $data['marca'], PDO::PARAM_STR);
            $stmt->bindParam(':logo', $data['logo'], PDO::PARAM_STR);
            $stmt->bindParam(':id_proveedor', $data['id_proveedor'], PDO::PARAM_INT);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            $afectados = $stmt->rowCount();
        }

        return $afectados;
    }

    function delete($id) {
        $afectados = 0;
        if (is_numeric($id)) {
            $sql = "DELETE FROM marca WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $afectados = $stmt->rowCount();
        }
        return $afectados;
    }
}
?>