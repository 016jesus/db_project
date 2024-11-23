<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Directivo</title>
    <script src="../media/style.js"></script>
    <link rel="stylesheet" href="../media/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script>
        function confirmarInsercion() {
            return confirm("¿Estás seguro de que deseas agregar este directivo?");
        }
    </script>
</head>
<body class="bg-gray-100">
    <?php include_once ("../main/header.php")?>
    <div class="container mx-auto mt-4">
        <div class="bg-white p-6 rounded shadow-md">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-bold">Agregar Directivo</h2>
                <a href="../main/index.php" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Inicio</a>
            </div>
            <?php 
            session_start();
            if (isset($_SESSION['mensaje'])) {
                echo $_SESSION['mensaje'];
                unset($_SESSION['mensaje']); // Eliminar el mensaje después de mostrarlo
            }
            ?>
            <form id="addDirectivoForm" action="procesar_add_directivo.php" method="POST" onsubmit="return confirmarInsercion();">
                <div class="mb-4">
                    <label for="nombre" class="block text-gray-700">Nombre:</label>
                    <input type="text" name="nombre" id="nombre" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                </div>
                <div class="mb-4">
                    <label for="apellido" class="block text-gray-700">Apellido:</label>
                    <input type="text" name="apellido" id="apellido" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                </div>
                <div class="mb-4">
                    <label for="cargo" class="block text-gray-700">Cargo:</label>
                    <select name="cargo" id="cargo" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                        <option value="">Seleccione un cargo</option>
                        <?php
                        include_once "../../connect.php";
                        $query = "SELECT cod_cargo, cargo FROM cargos";
                        $result = $conn->query($query);
                        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option value='{$row['cod_cargo']}'>{$row['cargo']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="cargo" class="block text-gray-700">Acto nombramiento:</label>
                    <select name="cod_nombram" id="cod_nombram" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                        <option value="">Seleccione un acto de nombramiento</option>
                        <?php

                        $query = "SELECT cod_nombram, nomb_nombramiento FROM acto_nombr";
                        $result = $conn->query($query);
                        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option value='{$row['cod_nombram']}'>{$row['nomb_nombramiento']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="institucion" class="block text-gray-700">Institución:</label>
                    <select name="institucion" id="institucion" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                        <option value="">Seleccione una institución</option>
                        <?php
                        $query = "SELECT cod_ies_padre, nomb_inst FROM instituciones";
                        $result = $conn->query($query);
                        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option value='{$row['cod_ies_padre']}'>{$row['nomb_inst']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Agregar Directivo</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>