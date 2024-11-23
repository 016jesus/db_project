

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <script src="../media/style.js"></script>
    <link rel="stylesheet" href="../media/style.css">
</head>
<body class="bg-gray-100">
<?php 
    session_start();
    include_once "../main/header.php";
?>
    <div class="container mx-auto">
        <div class="mt-4">
            <div class="flex justify-between items-center p-4 bg-gray-800 text-white">
                <div class="flex items-center">
                    <img src="../media/usuario.png" class="w-8 h-8 rounded-full mr-2">
                    <h2 class="text-2xl"><?php echo isset($_SESSION['username']) ? "Hola, ".htmlspecialchars($_SESSION['username']) : "Página de Usuario"; ?></h2>
                </div>
                <div>
                    <?php if (isset($_SESSION['username'])): ?>
                        <a href="../login/logout.php" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Cerrar sesión</a>
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

            <!-- Mostrar el rol del usuario -->
            <div class="bg-white shadow-md p-4 mt-4">
                <p class="text-gray-700">Rol: <?php echo isset($_SESSION['rol']) ? htmlspecialchars($_SESSION['rol']) : "No definido"; ?></p>
            </div>

            <!-- Botones centrados y agrandados -->
            <div class="mt-4 flex justify-center space-x-4">
                <a href="directivos.php" class="bg-blue-200 flex flex-col items-center p-10 rounded-lg shadow-lg transform transition-all duration-200 hover:scale-105 hover:bg-blue-300">
                    <img src="../media/directivos.png" alt="Directivos" class="w-32 h-32 mb-4">
                    <span class="text-2xl font-semibold">Directivos</span>
                </a>
                <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin'): ?>
                    <a href="registros_autoria.php" class="bg-blue-200 flex flex-col items-center p-10 rounded-lg shadow-lg transform transition-all duration-200 hover:scale-105 hover:bg-blue-300">
                        <img src="../media/postgres.png" alt="Registros de Autoria" class="w-32 h-32 mb-4">
                        <span class="text-2xl font-semibold">Registros de Autoria</span>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>