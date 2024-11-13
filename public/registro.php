<?php
include_once "connect.php";
session_start();

if (isset($_POST['registrarse'])) {
    $nombre_usuario = $_POST['nombre_usuario'];
    $correo_usuario = $_POST['correo_usuario'];
    $contraseña = $_POST['contraseña'];

    // Encriptar la contraseña
    $contraseña_hash = password_hash($contraseña, PASSWORD_BCRYPT);

    // Verificar si el correo ya está registrado
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE correo_usuario = :correo_usuario");
    $stmt->bindParam(':correo_usuario', $correo_usuario);
    $stmt->execute();
    
    if ($stmt->rowCount() > 0) {
        echo "Este correo ya está registrado.";
    } else {
        // Registrar el nuevo usuario
        $stmt = $conn->prepare("INSERT INTO usuarios (nombre_usuario, correo_usuario, contraseña) VALUES (:nombre_usuario, :correo_usuario, :contraseña)");
        $stmt->bindParam(':nombre_usuario', $nombre_usuario);
        $stmt->bindParam(':correo_usuario', $correo_usuario);
        $stmt->bindParam(':contraseña', $contraseña_hash);
        
        if ($stmt->execute()) {
            echo "Usuario registrado exitosamente. <a href='login.php'>Iniciar sesión</a>";
        } else {
            echo "Error al registrar el usuario.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Usuario</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background: linear-gradient(to bottom, #00c6ff, #0072ff);
            font-family: Arial, sans-serif;
            color: #fff;
        }

        form {
            background: rgba(255, 255, 255, 0.9); /* Fondo blanco con opacidad */
            border-radius: 10px;
            padding: 20px;
            width: 300px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Sombra para mayor contraste */
        }

        h2 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #0072ff; /* Color del título */
        }

        label {
            display: block;
            margin: 10px 0 5px;
            font-size: 14px;
            color: #333; /* Color del texto */
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 90%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            outline: none;
            font-size: 14px;
            color: #333;
            background: #f9f9f9; /* Color de fondo del campo */
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #ffcb00;
            border: none;
            border-radius: 5px;
            color: #333;
            font-weight: bold;
            cursor: pointer;
            font-size: 16px;
            margin-top: 10px;
        }

        button:hover {
            background-color: #ffc700;
        }

        input::placeholder {
            color: #aaa;
        }
    </style>
</head>
<body>
    <form method="POST" action="registro.php">
        <h2>Crear Cuenta</h2>
        <label>Nombre de usuario:</label>
        <input type="text" name="nombre_usuario" placeholder="Nombre de usuario" required>
        <label>Correo electrónico:</label>
        <input type="email" name="correo_usuario" placeholder="Correo electrónico" required>
        <label>Contraseña:</label>
        <input type="password" name="contraseña" placeholder="Contraseña" required>
        <button type="submit" name="registrarse">Registrarse</button>
    </form>
</body>
</html>
