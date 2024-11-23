<?php
session_start();
include_once "../../connect.php";
include_once "../../validation.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recibe los datos del formulario
    $correo_usuario = $_POST['email'];
    $contrasena = $_POST['password'];
    $nombre = $_POST['username'];


    $host  = $_SERVER['HTTP_HOST'];
    $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    $extra = 'index.php';


    if (!validatePassword($contrasena)) {
        $_SESSION['mensaje_error2'] = "Datos de entrada no válidos.";
        header("Location: registro.php");
        exit();
    }

    try {
        // Verificar si el correo electrónico ya existe
        $query = "SELECT * FROM privado.usuarios WHERE correo_usuario = :correo_usuario";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':correo_usuario', $correo_usuario, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            // Si el correo ya está registrado
            $_SESSION['mensaje_error2'] = "El correo electrónico ya está registrado. Intenta con otro.";
            header("Location: registro.php"); // Redirige al formulario de registro
            exit();
        } else {
            // Si el correo no está registrado, proceder con el registro
            $hashed_password = password_hash($contrasena, PASSWORD_BCRYPT);
            $contrasena = null; // Liberar la memoria
            $query = "INSERT INTO privado.usuarios (correo_usuario, password, nombre) 
                      VALUES (:correo_usuario, :password, :nombre)";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':correo_usuario', $correo_usuario, PDO::PARAM_STR);
            $stmt->bindParam(':password', $hashed_password, PDO::PARAM_STR);
            $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);

            if ($stmt->execute()) {
                $_SESSION['mensaje_exito'] = "Usuario registrado exitosamente.";
                header("Location: http://$host/$uri/login.php"); // Redirige al formulario de inicio de sesión
                exit();
            } else {
                $_SESSION['mensaje_error2'] = "Error al registrar el usuario.";
                header("Location: registro.php");
                exit();
            }
        }
    } catch (PDOException $e) {
        $_SESSION['mensaje_error2'] = "Error en la base de datos: " . $e->getMessage();
        header("Location: login/registro.php");
        exit();
    }
}
