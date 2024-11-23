<?php
// Iniciar la sesión al comienzo del archivo
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <script src="../media/style.js"></script>
    <link rel="stylesheet" href="../media/style.css">
</head>
<body class="bg-gray-100">
<?php 

include_once "../main/header.php";
?>
    <div class="container mx-auto mt-10">
        <div class="bg-gray-800 text-white p-4">
            <h2 class="text-2xl">Registro de Usuario</h2>

            <?php
                // Mostrar mensaje de error si existe y luego eliminarlo
                if (isset($_SESSION['mensaje_error2'])) {
                    echo "<p class='text-red-500'>" . $_SESSION['mensaje_error2'] . "</p>";
                    unset($_SESSION['mensaje_error2']); // Eliminar el mensaje después de mostrarlo
                }
            ?>
        </div>

        <div class="mt-4">
        <form action="procesar_registro.php" method="POST" class="bg-white p-6 rounded shadow-md">
            <div class="mb-4">
                <label for="username" class="block text-gray-700">Nombre Completo:</label>
                <input type="text" id="username" name="username" required class="mt-1 block w-full p-2 border border-gray-300 rounded">
            </div>
            <div class="mb-4">
                <label for="email" class="block text-gray-700">Correo Electrónico:</label>
                <input type="email" id="email" name="email" required class="mt-1 block w-full p-2 border border-gray-300 rounded">
            </div>
            <div class="mb-4">
                 <label for="password" class="block text-gray-700">Contraseña:</label>
                 <input type="password" id="password" name="password" required class="mt-1 block w-full p-2 border border-gray-300 rounded">
            </div>
            <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded hover:bg-blue-600">Registrar</button>
        </form>

        </div>
    </div>
</body>
</html>
