<?php

Class RolPermiso extends Sistema {

    function __construct(PDO $db) {
        if ($db instanceof PDO) {
            $this->db = $db;
            return;
        }

        parent::__construct();
    }

    function getPermisosByRol($id){
        $sql = "SELECT id_permiso FROM rol_permiso
            WHERE id_rol = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $roles = $stmt->fetchAll(PDO::FETCH_COLUMN);
        return $roles;
    }

    function syncPermisos ($id , $permisos) {
        if (is_numeric($id) && is_array($permisos)) {
            $permisos = array_unique($permisos);
            $permisos = array_values(array_filter($permisos, 'is_numeric'));

            $deletePermiso = $this->db->prepare(
                "DELETE FROM rol_permiso WHERE id_rol = :id_rol"
            );
            $deletePermiso->bindParam(':id_rol', $id, PDO::PARAM_INT);
            $deletePermiso->execute();

            $insertPermiso = $this->db->prepare(
                "INSERT INTO rol_permiso (id_rol, id_permiso)
                 VALUES (:id_rol, :id_permiso)"
            );
            $insertPermiso->bindParam(':id_rol', $id, PDO::PARAM_INT);
            foreach ($permisos as $permisoId) {
                $insertPermiso->bindValue(':id_permiso', (int) $permisoId, PDO::PARAM_INT);
                $insertPermiso->execute();
            }
        }

    }
}
?>