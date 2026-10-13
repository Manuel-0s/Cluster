<?php
require_once __DIR__ . '/models/producto/producto.class.php';

$modelo = new Producto();
$productos = $modelo->getAll();

require __DIR__ . '/../templates/admin/header.html';
require __DIR__ . '/../templates/admin/producto/index.html'; 
require __DIR__ . '/../templates/admin/footer.html';
?>