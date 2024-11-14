<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Directivo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto">
        <div class="mt-4">
            <div class="flex justify-between items-center p-4 bg-gray-800 text-white">
                <h2 class="text-2xl">Agregar Directivo</h2>
                <div>
                    <a href="index.php" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Inicio</a>
                </div>
                <div class="mb-4">
                    <p><?php echo "Hola, ".$_SESSION['username']; ?></p>
                </div>
            </div>

            <div class="flex mt-4">
                <div class="w-full bg-white shadow-md p-4">
                    <?php echo isset($_SESSION['mensaje'])? $_SESSION['mensaje']: "" ?>
                    <form id="addDirectivoForm" action="procesar_add_directivo.php" method="POST">
                        <div class="mb-4">
                            <label for="nombre" class="block text-gray-700">Nombre:</label>
                            <input type="text" name="nombre" id="nombre" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                        </div>
                        <div class="mb-4">
                            <label for="apellido" class="block text-gray-700">Apellido:</label>
                            <input type="text" name="apellido" id="apellido" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Agregar Directivo</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>