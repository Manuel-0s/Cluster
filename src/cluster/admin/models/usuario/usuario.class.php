<?php
require_once __DIR__ . '/../sistema.class.php';

class Usuario extends Sistema {

    function create($data) {
        $datos = [];
        $sql = "INSERT INTO usuario (correo, contrasena)
                VALUES (:correo, :contrasena)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':correo', $data['correo'], PDO::PARAM_STR);
        $stmt->bindParam(':contrasena', $data['contrasena'], PDO::PARAM_STR);
        $stmt->execute();
        $datos = $data;
        $datos['afectados'] = $stmt->rowCount();
        $datos['id'] = $this->db->lastInsertId();
        return $datos;
    }

    function getOne($id) {
        $datos = [];
        if (is_numeric($id)) {
            $sql = "SELECT * FROM usuario WHERE id_usuario = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $datos = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($datos) {
                $rolesStmt = $this->db->prepare(
                    "SELECT id_rol FROM usuario_rol WHERE id_usuario = :id_usuario"
                );
                
                $rolesStmt->bindParam(':id_usuario', $id, PDO::PARAM_INT);
                $rolesStmt->execute();
                $datos['roles'] = array_map(
                    'intval',
                    $rolesStmt->fetchAll(PDO::FETCH_COLUMN)
                );
            }
        }
        return $datos;
    }

    function getAll() {
        $datos = [];
        $sql = "SELECT * FROM usuario";
        $stmt = $this->db->query($sql);
        $datos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $datos;
    }

    function update($id, $data) {
        $afectados = 0;
        $roles = $data['id_rol'] ?? [];
        $roles = is_array($roles) ? array_unique($roles) : [];
        $roles = array_values(array_filter($roles, 'is_numeric'));

        if (is_numeric($id) && !empty($data) && !empty($roles)) {
            $sql = "UPDATE usuario
                    SET correo = :correo,
                        contrasena = :contrasena
                    WHERE id_usuario = :id";

            $this->db->beginTransaction();
            try {
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(':correo', $data['correo'], PDO::PARAM_STR);
                $stmt->bindParam(':contrasena', $data['contrasena'], PDO::PARAM_STR);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->execute();

                $deleteRole = $this->db->prepare(
                    "DELETE FROM usuario_rol WHERE id_usuario = :id_usuario"
                );
                
                $deleteRole->bindParam(':id_usuario', $id, PDO::PARAM_INT);
                $deleteRole->execute();

                $insertRole = $this->db->prepare(
                    "INSERT INTO usuario_rol (id_usuario, id_rol)
                     VALUES (:id_usuario, :id_rol)"
                );
                $insertRole->bindParam(':id_usuario', $id, PDO::PARAM_INT);
                foreach ($roles as $roleId) {
                    $insertRole->bindValue(':id_rol', (int) $roleId, PDO::PARAM_INT);
                    $insertRole->execute();
                }

                $this->db->commit();
                $afectados = $stmt->rowCount();
            } catch (PDOException $exception) {
                $this->db->rollBack();
                throw $exception;
            }
        }

        return $afectados;
    }

    function delete($id) {
        $afectados = 0;
        if (is_numeric($id)) {
            $sql = "DELETE FROM usuario WHERE id_usuario = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $afectados = $stmt->rowCount();
        }
        return $afectados;
    }
}
?>