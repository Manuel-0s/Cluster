<?php
require_once __DIR__ . '/../sistema.class.php';
require_once __DIR__ . '/rol_permiso.class.php';

class Rol extends Sistema {
    private $rolPermiso;

    function __construct() {
        parent::__construct();
        $this->rolPermiso = new RolPermiso($this->db);
    }

    function create($data) {
        $datos = [];
        $sql = "INSERT INTO rol (rol)
                VALUES (:rol)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':rol', $data['rol'], PDO::PARAM_STR);
        $stmt->execute();
        $datos = $data;
        $datos['afectados'] = $stmt->rowCount();
        $datos['id'] = $this->db->lastInsertId();
        return $datos;
    }

    function getOne($id) {
        $datos = [];
        if (is_numeric($id)) {
            $sql = "SELECT * FROM rol WHERE id_rol = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $datos = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($datos) {
                $datos['permisos'] = $this->rolPermiso->getPermisosByRol($id);
            }
        }
        return $datos;
    }

    function getAll() {
        $datos = [];
        $sql = "SELECT * FROM rol";
        $stmt = $this->db->query($sql);
        $datos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $datos;
    }

    function update($id, $data) {
        $afectados = 0;
        if (is_numeric($id) && !empty($data)) {
            $sql = "UPDATE rol
                    SET rol = :rol
                    WHERE id_rol = :id";

            $this -> db -> beginTransaction();

            try {
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(':rol', $data['rol'], PDO::PARAM_STR);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->execute();

                $this->rolPermiso->syncPermisos($id, $data['id_permiso'] ?? []);

                $this -> db -> commit();
            } catch (Exception $e) {
                $this -> db -> rollBack();
                throw $e;
            }
            $afectados = $stmt->rowCount();
        }

        return $afectados;
    }

    function delete($id) {
        $afectados = 0;
        if (is_numeric($id)) {
            $sql = "DELETE FROM rol WHERE id_rol = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $afectados = $stmt->rowCount();
        }
        return $afectados;
    }
}
?>