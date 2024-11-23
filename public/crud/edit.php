<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Directivo</title>
    <script src="../media/style.js"></script>
    <link rel="stylesheet" href="../media/style.css">
    <script>
        function confirmarActualizacion() {
            return confirm("¿Estás seguro de que deseas actualizar la información del directivo?");
        }
    </script>
</head>
<body class="bg-white min-h-screen flex items-center justify-center">
    <div class="w-full max-w-lg mx-auto bg-white border border-gray-300 rounded-lg shadow-lg overflow-hidden">
        
        <div class="bg-blue-600 p-4">
            <h2 class="text-2xl font-bold text-white text-center">Editar Directivo</h2>
        </div>

        <div class="p-6">
            <?php
            session_start();
            include_once "../../connect.php";
            include_once "../../validation.php"; // Asegúrate de incluir el archivo de validación

            $error = null;
            $directivo = null;
            $cargos = [];
            $cargosDirectivo = [];

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $cod_dir = $_SESSION['cod_dir'];
                $nombre = $_POST['nombre'];
                $apellido = $_POST['apellido'];
                $cargo = $_POST['cargo'];
                $cod_ies_padre = $_SESSION['cod_ies_padre'];

                // Validar los datos de entrada
                if (!validateText($nombre) || !validateText($apellido) || !validateNumber($cargo)) {
                    $error = "Datos de entrada no válidos.";
                } else {
                    try {
                        // Verificar si el cargo ya está ocupado por otro directivo en la misma institución
                        $query = "SELECT COUNT(*) FROM rigen r
                                  JOIN directivos d ON r.cod_dir = d.cod_dir
                                  WHERE r.cod_cargo = :cargo AND r.cod_dir != :cod_dir AND r.cod_ies_padre = :cod_ies_padre";
                        $stmt = $conn->prepare($query);
                        $stmt->bindParam(':cargo', $cargo, PDO::PARAM_INT);
                        $stmt->bindParam(':cod_dir', $cod_dir, PDO::PARAM_INT);
                        $stmt->bindParam(':cod_ies_padre', $cod_ies_padre, PDO::PARAM_INT);
                        $stmt->execute();
                        $count = $stmt->fetchColumn();

                        if ($count > 0) {
                            $error = "El cargo seleccionado ya está ocupado por otro directivo en la misma institución.";
                        } else {
                            // Actualizar los datos del directivo
                            $query = "UPDATE directivos SET nombre = :nombre, apellido = :apellido WHERE cod_dir = :cod_dir";
                            $stmt = $conn->prepare($query);
                            $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
                            $stmt->bindParam(':apellido', $apellido, PDO::PARAM_STR);
                            $stmt->bindParam(':cod_dir', $cod_dir, PDO::PARAM_INT);
                            $stmt->execute();

                            // Actualizar el cargo del directivo
                            $query = "UPDATE rigen SET cod_cargo = :cargo WHERE cod_dir = :cod_dir";
                            $stmt = $conn->prepare($query);
                            $stmt->bindParam(':cargo', $cargo, PDO::PARAM_INT);
                            $stmt->bindParam(':cod_dir', $cod_dir, PDO::PARAM_INT);
                            $stmt->execute();

                            header("Location: directivos.php");
                            exit();
                        }
                    } catch (PDOException $e) {
                        $error = "Error en la base de datos: " . $e->getMessage();
                    }
                }
            } else {
                $cod_dir = $_GET['cod_dir'];
                $_SESSION['cod_dir'] = $cod_dir;
            }

            // Obtener los datos del directivo y los cargos disponibles
            if ($cod_dir != null) {
                $query = "SELECT d.nombre, d.apellido, r.cod_cargo, i.nomb_inst, r.cod_ies_padre FROM directivos d
                          JOIN rigen r ON d.cod_dir = r.cod_dir
                          JOIN instituciones i ON r.cod_ies_padre = i.cod_ies_padre
                          WHERE d.cod_dir = :cod_dir";
                $stmt = $conn->prepare($query);
                $stmt->bindParam(':cod_dir', $cod_dir, PDO::PARAM_INT);
                $stmt->execute();
                $directivo = $stmt->fetch(PDO::FETCH_ASSOC);

                $_SESSION['cod_ies_padre'] = $directivo['cod_ies_padre'];

                $query = "SELECT cod_cargo, cargo FROM cargos";
                $cargos = $conn->query($query)->fetchAll(PDO::FETCH_ASSOC);

                // Obtener los cargos actuales del directivo
                $query = "SELECT c.cargo FROM rigen r
                          JOIN cargos c ON r.cod_cargo = c.cod_cargo
                          WHERE r.cod_dir = :cod_dir";
                $stmt = $conn->prepare($query);
                $stmt->bindParam(':cod_dir', $cod_dir, PDO::PARAM_INT);
                $stmt->execute();
                $cargosDirectivo = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            ?>

            <?php if (isset($error)): ?>
                <p class="text-red-500 text-center mb-4"><?php echo $error; ?></p>
            <?php endif; ?>

            <form action="procesar_edit.php" method="POST" class="space-y-4" onsubmit="return confirmarActualizacion();">
                <div>
                    <label for="nombre" class="block text-sm font-semibold text-gray-700">Nombre</label>
                    <input type="text" name="nombre" id="nombre" value="<?php echo htmlspecialchars($directivo['nombre']); ?>" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>

                <div>
                    <label for="apellido" class="block text-sm font-semibold text-gray-700">Apellido</label>
                    <input type="text" name="apellido" id="apellido" value="<?php echo htmlspecialchars($directivo['apellido']); ?>" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>

                <div>
                    <label for="institucion" class="block text-sm font-semibold text-gray-700">Institución</label>
                    <input type="text" name="institucion" id="institucion" value="<?php echo htmlspecialchars($directivo['nomb_inst']); ?>" disabled
                           class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>

                <div>
                    <label for="cargo" class="block text-sm font-semibold text-gray-700">Cargo Actual</label>
                    <select name="cargo" id="cargo" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
                        <?php foreach ($cargos as $cargo): ?>
                            <option value="<?php echo $cargo['cod_cargo']; ?>" <?php echo ($cargo['cod_cargo'] == $directivo['cod_cargo']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($cargo['cargo']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700">Cargos del Directivo en la Institución</label>
                    <ul class="list-disc pl-5">
                        <?php foreach ($cargosDirectivo as $cargo): ?>
                            <li><?php echo htmlspecialchars($cargo['cargo']); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <div class="flex justify-between mt-6">
                    <a href="directivos.php" class="px-4 py-2 bg-gray-500 text-white rounded-md shadow hover:bg-gray-600">
                        <i class="fas fa-arrow-left mr-2"></i>Cancelar
                    </a>
                    <button type="submit" name="submit" value="true" class="px-6 py-2 bg-blue-600 text-white font-semibold rounded-md shadow hover:bg-blue-700 transition duration-200">
                        <i class="fas fa-save mr-2"></i>Guardar Cambios
                    </button>
                </div>
                <br>
                <a href="directivos.php" class="px-4 py-2 bg-gray-500 text-white rounded-md shadow hover:bg-gray-600">
    <i class="fas fa-arrow-left mr-2"></i>Volver
</a>
            </form>
            
        </div>

        <div class="bg-gray-100 p-4 text-center">
            <p class="text-xs text-gray-500">Estás editando la información de un directivo. Asegúrate de guardar los cambios antes de salir.</p>
        </div>
        
    </div>
    
</body>
</html>