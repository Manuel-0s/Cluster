<?php
require_once __DIR__ . '/../sistema.class.php';
include_once __DIR__ . '/usuario_rol.class.php';

class Usuario extends Sistema {
    private $usuarioRol;

    function __construct() {
        parent::__construct();
        $this->usuarioRol = new UsuarioRol($this->db);
    }

    function create($data) {
        $data['contrasena'] = password_hash($data['contrasena'], PASSWORD_DEFAULT);

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
                $datos['roles'] = $this->usuarioRol->getRolesByUsuario($id);
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

        if (!empty($data['contrasena'])) {
            $data['contrasena'] = password_hash($data['contrasena'], PASSWORD_DEFAULT);
        } else {
            $data['contrasena'] = $this -> getOne($id)['contrasena'];
        }

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


                $this->usuarioRol->syncRoles($id, $roles);

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