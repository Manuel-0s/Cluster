<?php
/**
 * Página de prueba para el entorno de desarrollo
 */

// Configuración de errores para desarrollo
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo '<h1>Entorno de Desarrollo Web</h1>';
echo '<h2>Informacion del Sistema</h2>';

// Información de PHP
echo '<h3>PHP</h3>';
echo '<p><strong>Version:</strong> ' . PHP_VERSION . '</p>';
echo '<p><strong>Extensiones cargadas:</strong> ' . count(get_loaded_extensions()) . '</p>';

// Probar conexión a MariaDB
echo '<h3>MariaDB</h3>';
try {
    $pdo = new PDO('mysql:host=mariadb;dbname=database;port=3306', 'user', 'password');
    echo '<p style="color: green;">Conexion exitosa a MariaDB</p>';
    $result = $pdo->query('SELECT VERSION() as version');
    $version = $result->fetch()['version'];
    echo '<p><strong>Version:</strong> ' . $version . '</p>';
} catch (PDOException $e) {
    echo '<p style="color: red;">Error conectando a MariaDB: ' . $e->getMessage() . '</p>';
}

// Probar conexión a PostgreSQL
echo '<h3>PostgreSQL</h3>';
try {
    $pdo = new PDO('pgsql:host=postgres;dbname=database;port=5432', 'user', 'password');
    echo '<p style="color: green;">Conexion exitosa a PostgreSQL</p>';
    $result = $pdo->query('SELECT version()');
    $version = $result->fetch()[0];
    echo '<p><strong>Version:</strong> ' . substr($version, 0, 50) . '...</p>';
} catch (PDOException $e) {
    echo '<p style="color: red;">Error conectando a PostgreSQL: ' . $e->getMessage() . '</p>';
}

// PostgreSQL
$postgres = new PDO('pgsql:host=postgres;dbname=database', 'user', 'password');
$stmt = $postgres->query("SELECT * FROM mundo");
$datos = $stmt->fetchAll();
print_r($datos);

echo "<hr>";

// MariaDB  
$mariadb = new PDO('mysql:host=mariadb;dbname=database', 'user', 'password');
$stmt = $mariadb->query("SELECT * FROM mundo");
$datos = $stmt->fetchAll();
print_r($datos);


// Mostrar extensiones importantes
echo '<h3>Extensiones PHP Instaladas</h3>';
$important_extensions = [
    'pdo', 'pdo_mysql', 'pdo_pgsql', 'mysqli', 'pgsql',
    'gd', 'imagick', 'curl', 'zip', 'xml', 'json',
    'mbstring', 'intl', 'redis', 'memcached', 'xdebug'
];



// Test de generación de imágenes
echo '<h3>Test Generacion de Imagenes</h3>';
if (extension_loaded('gd')) {
    $img = imagecreate(200, 100);
    $bg = imagecolorallocate($img, 255, 255, 255);
    $text_color = imagecolorallocate($img, 0, 0, 0);
    imagestring($img, 5, 30, 40, 'PHP GD OK!', $text_color);
    
    ob_start();
    imagepng($img);
    $image_data = ob_get_contents();
    ob_end_clean();
    echo '<img src="data:image/png;base64,' . base64_encode($image_data) . '" alt="Test GD">';
    imagedestroy($img);
} else {
    echo '<p style="color: red;">Extension GD no disponible</p>';
}

phpinfo();
?>