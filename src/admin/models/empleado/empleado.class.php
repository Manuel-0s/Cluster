<?php
require_once __DIR__ . '/../sistema.class.php';

class Empleado extends Sistema {

    function create($data) {
        $datos = [];
        $data['foto'] = $this->cargarArchivo('foto', '/../../images/uploads/');
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

            $sql = "INSERT INTO empleado (nombre, primer_apellido, segundo_apellido, rfc, foto, id_usuario)
                    VALUES (:nombre, :primer_apellido, :segundo_apellido, :rfc, :foto, :id_usuario)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':nombre', $data['nombre'], PDO::PARAM_STR);
            $stmt->bindParam(':primer_apellido', $data['primer_apellido'], PDO::PARAM_STR);
            $stmt->bindParam(':segundo_apellido', $data['segundo_apellido'], PDO::PARAM_STR);
            $stmt->bindParam(':rfc', $data['rfc'], PDO::PARAM_STR);
            $stmt->bindParam(':foto', $data['foto'], PDO::PARAM_STR);
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

    function generarListadoPdf() {
        require_once __DIR__ . '/../../../vendor/autoload.php';

        $empleados = $this->getAll();
        $filas = '';

        foreach ($empleados as $empleado) {
            $foto = '';
            if (!empty($empleado['foto'])) {
                $rutaFoto = __DIR__ . '/../../../images/uploads/' . basename($empleado['foto']);
                if (is_file($rutaFoto)) {
                    $tipoFoto = mime_content_type($rutaFoto);
                    $foto = '<img class="foto" src="data:' . $tipoFoto . ';base64,' .
                        base64_encode(file_get_contents($rutaFoto)) . '" alt="Foto">';
                }
            }

            $nombre = htmlspecialchars(trim(
                ($empleado['nombre'] ?? '') . ' ' .
                ($empleado['primer_apellido'] ?? '') . ' ' .
                ($empleado['segundo_apellido'] ?? '')
            ), ENT_QUOTES, 'UTF-8');
            $correo = htmlspecialchars($empleado['correo'] ?? '', ENT_QUOTES, 'UTF-8');
            $rfc = htmlspecialchars($empleado['rfc'] ?? '', ENT_QUOTES, 'UTF-8');

            $filas .= '<tr>
                <td>' . (int) $empleado['id_empleado'] . '</td>
                <td>' . $foto . '</td>
                <td>' . $nombre . '</td>
                <td>' . $correo . '</td>
                <td>' . $rfc . '</td>
            </tr>';
        }

        if ($filas === '') {
            $filas = '<tr><td colspan="5" class="vacio">No hay empleados registrados.</td></tr>';
        }

        $html = '<!doctype html>
            <html lang="es">
            <head>
                <meta charset="UTF-8">
                <style>
                    @page { margin: 28px; }
                    body { font-family: DejaVu Sans, sans-serif; color: #212529; }
                    h1 { color: #198754; font-size: 20px; margin-bottom: 18px; }
                    table { width: 100%; border-collapse: collapse; font-size: 10px; }
                    th { background: #198754; color: #fff; text-align: left; }
                    th, td { border: 1px solid #ced4da; padding: 7px; vertical-align: middle; }
                    .foto { width: 42px; height: 42px; object-fit: cover; }
                    .vacio { text-align: center; }
                </style>
            </head>
            <body>
                <h1>Listado de empleados</h1>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Foto</th>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>RFC</th>
                        </tr>
                    </thead>
                    <tbody>' . $filas . '</tbody>
                </table>
            </body>
            </html>';

        $mpdf = new \Mpdf\Mpdf([
            'format' => 'Letter',
            'orientation' => 'L',
            'margin_left' => 28,
            'margin_right' => 28,
            'margin_top' => 28,
            'margin_bottom' => 28
        ]);
        $mpdf->WriteHTML($html);
        $mpdf->Output('listado-empleados.pdf', 'D');
        exit;
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