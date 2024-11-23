<?php
// Archivo de conexión a la base de datos

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$host  = $_SERVER['HTTP_HOST'];
$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$extra = 'index.php';
    
/**
 * Conectar a la base de datos como usuario por defecto (api).
 * jesusdel1611@gmail.com | $2y$10$hrah1bbg0ZwY4N6O79KIAe38mm9W.itfsQ1t6z6dCDKS4rPDotFAC | Jesus Delgado | admin
 *
 * @return PDO La conexión a la base de datos.
 */
function connectDefault() {
    $username = 'api';
    $password = 'apipassword';
    return connect($username, $password);
}

/**
 * Conectar a la base de datos con usuario y contraseña específicos.
 *
 * @param string $username El nombre de usuario.
 * @param string $password La contraseña del usuario.
 * @return PDO La conexión a la base de datos.
 */
function connectWithCredentials($username, $password) {
    $conn = connect("postgres", "postgres");
    $query = "SELECT password FROM privado.usuarios WHERE correo_usuario = $username";
    $user = $conn->query($query);
    $hashed_password_db = $user->fetchColumn();
    $conn = null;
    if (password_verify($password, $hashed_password_db)) {

        $dbpassword = $hashed_password_db; // Ahora puedes usar la contraseña en texto claro

     return connect( $username, $dbpassword);
} else {
    echo "Contraseña incorrecta";
    exit();
}
}

/**
 * Conectar a la base de datos.
 *
 * @param string $username El nombre de usuario.
 * @param string $password La contraseña del usuario.
 * @return PDO La conexión a la base de datos.
 */
function connect($username, $password) {
    try {
        $conn = new PDO("pgsql:host=localhost;dbname=institucionesv2", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        echo "Error connecting to the database: <br>" . $e->getMessage();
        exit();
    }
}


$conn = connectDefault();   