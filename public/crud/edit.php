<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Directivo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body class="bg-white min-h-screen flex items-center justify-center">
    <div class="w-full max-w-lg mx-auto bg-white border border-gray-300 rounded-lg shadow-lg overflow-hidden">
        <!-- Header -->
        <div class="bg-blue-600 p-4">
            <h2 class="text-2xl font-bold text-white text-center">Editar Directivo</h2>
        </div>

        <!-- Formulario -->
        <div class="p-6">
            <?php if (isset($error)): ?>
                <p class="text-red-500 text-center mb-4"><?php echo $error; ?></p>
            <?php endif; ?>

            <form action="" method="POST" class="space-y-4">
                <!-- Código -->
                <div>
                    <label for="cod_dir" class="block text-sm font-semibold text-gray-700">Código</label>
                    <input type="text" name="cod_dir" id="cod_dir" value="<?php echo htmlspecialchars($directivo['cod_dir']); ?>" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>

                <!-- Nombre -->
                <div>
                    <label for="nombre" class="block text-sm font-semibold text-gray-700">Nombre</label>
                    <input type="text" name="nombre" id="nombre" value="<?php echo htmlspecialchars($directivo['nombre']); ?>" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>

                <!-- Apellido -->
                <div>
                    <label for="apellido" class="block text-sm font-semibold text-gray-700">Apellido</label>
                    <input type="text" name="apellido" id="apellido" value="<?php echo htmlspecialchars($directivo['apellido']); ?>" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>

                <!-- Botones -->
                <div class="flex justify-between mt-6">
                    <a href="directivos.php" class="px-4 py-2 bg-gray-500 text-white rounded-md shadow hover:bg-gray-600">
                        <i class="fas fa-arrow-left mr-2"></i>Cancelar
                    </a>
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white font-semibold rounded-md shadow hover:bg-blue-700 transition duration-200">
                        <i class="fas fa-save mr-2"></i>Guardar
                    </button>
                </div>
            </form>
        </div>

        <!-- Footer -->
        <div class="bg-gray-100 p-4 text-center">
            <p class="text-xs text-gray-500">Estás editando la información de un directivo. Asegúrate de guardar los cambios antes de salir.</p>
        </div>
    </div>
</body>
</html>
