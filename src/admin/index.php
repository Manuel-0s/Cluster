<?php
    include_once __DIR__ . '/models/sistema.class.php';
    include_once __DIR__ . '/models/proveedor/proveedor.class.php';

    $app = new Sistema();
    $appProveedor = new Proveedor();

    $app -> checarRol("Empleado");

    $proveedores = $appProveedor->getProvedoresProductos();
    
    include_once __DIR__ . '/../templates/admin/header.html';
    include_once __DIR__ . '/../templates/admin/index.html';
    include_once __DIR__ . '/../templates/admin/footer.html';
?>