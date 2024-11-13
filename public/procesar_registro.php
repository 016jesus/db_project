<?php
// Habilitar la visualización de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//conexión a la base de datos
include_once "../connect.php"; 
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recibir los datos del formulario
    $correo_usuario = $_POST['email'];
    $contrasena = $_POST['password'];
    $nombre_completo = $_POST['username'];

    try {
        // Hashear la contraseña 
        $hashed_password = password_hash($contrasena, PASSWORD_BCRYPT);

        //sentencia SQL 
        $query = "INSERT INTO privado.usuarios (correo_usuario, contraseña, nombre_completo) 
                  VALUES (:correo_usuario, :contrasena, :nombre_completo)";
        $stmt = $conn->prepare($query);

        // Vincular los parámetros con los valores
        $stmt->bindParam(':correo_usuario', $correo_usuario, PDO::PARAM_STR);
        $stmt->bindParam(':contrasena', $hashed_password, PDO::PARAM_STR);
        $stmt->bindParam(':nombre_completo', $nombre_completo, PDO::PARAM_STR);

        // Ejecutar la sentencia
        if ($stmt->execute()) {
          
            $_SESSION['mensaje_exito'] = "Usuario creado con éxito.";
            header("Location: login.php"); 
            exit();
        } else {
            echo "Error al registrar el usuario.";
        }
    } catch (PDOException $e) {
        echo "Error en la inserción: " . $e->getMessage();
    }
}
?>
