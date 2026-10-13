<?php
require_once __DIR__ . '/../sistema.class.php';

class Permiso extends Sistema {

    function create($data) {
        $datos = [];
        $sql = "INSERT INTO permiso (permiso)
                VALUES (:permiso)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':permiso', $data['permiso'], PDO::PARAM_STR);
        $stmt->execute();
        $datos = $data;
        $datos['afectados'] = $stmt->rowCount();
        $datos['id'] = $this->db->lastInsertId();
        return $datos;
    }

    function getOne($id) {
        $datos = [];
        if (is_numeric($id)) {
            $sql = "SELECT * FROM permiso WHERE id_permiso = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $datos = $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return $datos;
    }

    function getAll() {
        $datos = [];
        $sql = "SELECT * FROM permiso";
        $stmt = $this->db->query($sql);
        $datos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $datos;
    }

    function update($id, $data) {
        $afectados = 0;
        if (is_numeric($id) && !empty($data)) {
            $sql = "UPDATE permiso
                    SET permiso = :permiso
                    WHERE id_permiso = :id";

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':permiso', $data['permiso'], PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            $afectados = $stmt->rowCount();
        }

        return $afectados;
    }

    function delete($id) {
        $afectados = 0;
        if (is_numeric($id)) {
            $sql = "DELETE FROM permiso WHERE id_permiso = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $afectados = $stmt->rowCount();
        }
        return $afectados;
    }
}
?>