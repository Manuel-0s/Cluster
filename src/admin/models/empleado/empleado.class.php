<?php
require_once __DIR__ . '/../sistema.class.php';

class Empleado extends Sistema {

    function create($data) {
        $datos = [];
        $this->db->beginTransaction();
        try {
            $sql = "INSERT INTO usuario (correo, contrasena)
                    VALUES (:correo, :contrasena)";

            $data['contrasena'] = password_hash($data['contrasena'], PASSWORD_DEFAULT);

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':correo', $data['correo'], PDO::PARAM_STR);
            $stmt->bindParam(':contrasena', $data['contrasena'], PDO::PARAM_STR);
            $stmt->execute();

            $sql = "SELECT id_usuario FROM usuario
                    WHERE correo = :correo";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':correo', $data['correo'], PDO::PARAM_STR);
            $stmt->execute();
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
            $id_usuario = $usuario['id_usuario'];

            $sql = "INSERT INTO usuario_rol (id_usuario, id_rol)
                    VALUES (:id_usuario, :id_rol)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
            $stmt->bindValue(':id_rol', 2, PDO::PARAM_INT);
            $stmt->execute();

            $sql = "INSERT INTO empleado (nombre, primer_apellido, segundo_apellido, rfc, id_usuario)
                    VALUES (:nombre, :primer_apellido, :segundo_apellido, :rfc, :id_usuario)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':nombre', $data['nombre'], PDO::PARAM_STR);
            $stmt->bindParam(':primer_apellido', $data['primer_apellido'], PDO::PARAM_STR);
            $stmt->bindParam(':segundo_apellido', $data['segundo_apellido'], PDO::PARAM_STR);
            $stmt->bindParam(':rfc', $data['rfc'], PDO::PARAM_STR);
            $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
            $stmt->execute();

            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    function getOne($id) {
        $datos = [];
        if (is_numeric($id)) {
            $sql = "SELECT * FROM empleado WHERE id_empleado = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $datos = $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return $datos;
    }

    function getAll() {
        $datos = [];
        $sql = "SELECT * FROM empleado e
                JOIN usuario u ON e.id_usuario = u.id_usuario";
                  
        $stmt = $this->db->query($sql);
        $datos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $datos;
    }

    function update($id, $data) {
        $afectados = 0;
        if (is_numeric($id) && !empty($data)) {
            $sql = "UPDATE empleado
                    SET nombre = :nombre,
                        primer_apellido = :primer_apellido,
                        segundo_apellido = :segundo_apellido,
                        rfc = :rfc
                    WHERE id_empleado = :id";

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':nombre', $data['nombre'], PDO::PARAM_STR);
            $stmt->bindParam(':primer_apellido', $data['primer_apellido'], PDO::PARAM_STR);
            $stmt->bindParam(':segundo_apellido', $data['segundo_apellido'], PDO::PARAM_STR);
            $stmt->bindParam(':rfc', $data['rfc'], PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            $afectados = $stmt->rowCount();
        }

        return $afectados;
    }

    function delete($id) {
        $afectados = 0;
        if (is_numeric($id)) {
            $sql = "DELETE FROM empleado WHERE id_empleado = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $afectados = $stmt->rowCount();
        }
        return $afectados;
    }
}
?>