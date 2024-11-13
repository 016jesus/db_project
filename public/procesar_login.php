<?php
// Habilitar la visualización de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include_once "../connect.php"; // Asegúrate de que este archivo tiene la conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Consulta para obtener el usuario por nombre de usuario
    $query = "SELECT * FROM privado.usuarios WHERE nombre_completo = :username";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verificar si el usuario existe y si la contraseña coincide
    if ($user && password_verify($password, $user['contraseña'])) {
        // Iniciar sesión y guardar el nombre de usuario en la sesión
        $_SESSION['username'] = $user['nombre_completo'];
        $_SESSION['mensaje_exito'] = "Inicio de sesión exitoso.";

        header("Location: modificaciones.php");
        exit();
    } else {
        // Si las credenciales son incorrectas, mostrar un mensaje de error
        $_SESSION['mensaje_error'] = "Nombre de usuario o contraseña incorrectos.";
        header("Location: login.php");
        exit();
    }
}
?>
