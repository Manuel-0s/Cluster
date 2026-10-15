<?php 
require_once __DIR__ . '/../sistema.class.php';

Class UsuarioRol extends Sistema {

    function getRolesByUsuario($id){
        $sql = "SELECT id_rol FROM usuario_rol 
            WHERE id_usuario = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $roles = $stmt->fetchAll(PDO::FETCH_COLUMN);
        return $roles;
    }

    function syncRoles ($id, array $roles){
        $sql = "DELETE FROM usuario_rol WHERE id_usuario = :id";
        $stmt = $this->db->prepare($sql);
        $stmt -> bindParam(":id", $id, PDO::PARAM_INT);
        $stmt -> execute();
    }
}

?>