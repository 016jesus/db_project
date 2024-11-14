<?php 
    session_start();
    include_once "header.php"; 
?>




<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    
    <div class="container mx-auto">
        <div class="mt-4">
            <div class="flex justify-between items-center p-4 bg-gray-800 text-white">
                <div class="flex items-center">
                    <img src="../media/usuario.png" class="w-8 h-8 rounded-full mr-2">
                    <h2 class="text-2xl"><?php echo isset($_SESSION['username']) ? "Hola, ".htmlspecialchars($_SESSION['username']) : "Página de Usuario"; ?></h2>
                </div>
                <div>
                    <?php if (isset($_SESSION['username'])): ?>
                        <a href="logout.php" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Cerrar sesión</a>
                    <?php else: ?>
                        <a href="login.php" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Iniciar Sesión</a>
                        <a href="registro.php" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 ml-2">Registrar</a>
                    <?php endif; ?>
                </div>
            </div>

            <div class="bg-white shadow-md p-4 mt-4">
                <?php if (isset($_SESSION['mensaje_exito'])): ?>
                    <p class="text-green-500"><?php echo $_SESSION['mensaje_exito']; unset($_SESSION['mensaje_exito']); ?></p>
                <?php endif; ?>
            </div>

            <!-- Botones con imágenes -->
            <div class="mt-4 grid grid-cols-1 sm:grid-cols-3 gap-4">
                <a href="directivos.php" class="bg-blue-200 flex flex-col items-center p-6 rounded-lg shadow transform transition-all duration-200 hover:scale-105 hover:bg-blue-300">
                    <img src="../media/directivos.png" alt="Directivos" class="w-20 h-20 mb-2">
                    <span class="text-lg font-semibold">Directivos</span>
                </a>
                <a href="inst_por_mun.php" class="bg-green-200 flex flex-col items-center p-6 rounded-lg shadow transform transition-all duration-200 hover:scale-105 hover:bg-green-300">
                    <img src="../media/colombia.png" alt="Instituciones por Municipio" class="w-20 h-20 mb-2">
                    <span class="text-lg font-semibold">Instituciones por Municipio</span>
                </a>
                <a href="instituciones.php" class="bg-indigo-200 flex flex-col items-center p-6 rounded-lg shadow transform transition-all duration-200 hover:scale-105 hover:bg-indigo-300">
                    <img src="../media/instituciones.png" alt="Instituciones" class="w-20 h-20 mb-2">
                    <span class="text-lg font-semibold">Instituciones</span>
                </a>
            </div>
        </div>
    </div>
</body>
</html>