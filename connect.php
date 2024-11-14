
<?php
//archivo de conexion a la base de datos


// config.php
define('DB_HOST', 'localhost');
define('DB_PORT', '5432');
define('DB_NAME', 'instituciones');
define('DB_USER', 'api');
define('DB_PASSWORD', 'apipassword');




    try {
        $conn = new PDO("pgsql:host=".$ENV.DB_HOST.";dbname=" .$ENV.DB_NAME, $ENV.DB_USER, $ENV.DB_PASSWORD);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    } catch (PDOException $e) {
        echo "Error connecting to the database: <br>" . $e;
    }


