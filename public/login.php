<?php 

session_start();


include_once "../atributtes.php";

// Verifica si hay un mensaje de éxito de registro almacenado
$mensaje_exito = isset($_SESSION['mensaje_exito']) ? $_SESSION['mensaje_exito'] : null;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    <script src="../media/style.js"></script>
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto mt-10">
        <div class="bg-gray-800 text-white p-4">
            <h2 class="text-2xl">Inicio de Sesión</h2>
        </div>
        
        <?php

            if (isset($_SESSION['mensaje_error'])) {
                echo "<p class='text-red-500'>" . $_SESSION['mensaje_error'] . "</p>";
                unset($_SESSION['mensaje_error']); 
            }
            

            if ($mensaje_exito) {
                echo "<div class='bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative' role='alert'>
                        <span class='block sm:inline'>{$mensaje_exito}</span>
                      </div>";
                unset($_SESSION['mensaje_exito']); 
            }
        ?>

        <div class="mt-4">
            <form action="procesar_login.php" method="POST" class="bg-white p-6 rounded shadow-md">
                <div class="mb-4">
                    <label for="username" class="block text-gray-700">Usuario:</label>
                    <input type="text" id="username" name="username" required class="mt-1 block w-full p-2 border border-gray-300 rounded">
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-gray-700">Contraseña:</label>
                    <input type="password" id="password" name="password" required class="mt-1 block w-full p-2 border border-gray-300 rounded">
                </div>
                <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded hover:bg-blue-600">Iniciar Sesión</button>
            </form>
        </div>
    </div>
</body>
</html>
