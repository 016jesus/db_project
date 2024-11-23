<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Directivos</title>
    <script src="../media/style.js"></script>
    <link rel="stylesheet" href="../media/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto mt-4">
        <?php include_once ("../main/header.php")?>
        <h1 class="text-2xl font-bold mb-4">Directivos</h1>
        <form method="GET" action="directivos.php" class="mb-4">
            <input type="text" name="search" placeholder="Buscar por nombre" value="<?php echo htmlspecialchars($search); ?>" class="border p-2 rounded">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Buscar</button>
        </form>
        <table class="min-w-full bg-white">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b">#</th>
                    <th class="py-2 px-4 border-b">ID</th>
                    <th class="py-2 px-4 border-b">Nombre</th>
                    <th class="py-2 px-4 border-b">Apellido</th>
                    <th class="py-2 px-4 border-b">Cargo</th>
                    <th class="py-2 px-4 border-b">Institución</th>
                    <th class="py-2 px-4 border-b">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Habilitar la visualización de errores para depuración
                ini_set('display_errors', 1);
                ini_set('display_startup_errors', 1);
                error_reporting(E_ALL);

                include_once "../../connect.php";

                // Configuración de la paginación
                $limit = 10; // Número de registros por página
                $page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Página actual
                $offset = ($page - 1) * $limit; // Offset para la consulta

                // Filtro de búsqueda
                $search = isset($_GET['search']) ? trim($_GET['search']) : '';

                try {
                    // Consulta para contar el total de registros
                    $countQuery = "SELECT COUNT(*) as total FROM directivos d
                                   JOIN rigen r ON d.cod_dir = r.cod_dir
                                   JOIN instituciones i ON r.cod_ies_padre = i.cod_ies_padre";
                    if ($search) {
                        $countQuery .= " WHERE d.nombre ILIKE :search";
                    }
                    $countStmt = $conn->prepare($countQuery);
                    if ($search) {
                        $countStmt->bindValue(':search', "%$search%");
                    }
                    $countStmt->execute();
                    $total = $countStmt->fetch(PDO::FETCH_ASSOC)['total'];
                    $totalPages = ceil($total / $limit);

                    // Consulta para obtener los registros
                    $query = "SELECT d.cod_dir, d.nombre, d.apellido, c.cargo, i.nomb_inst FROM directivos d
                              JOIN rigen r ON d.cod_dir = r.cod_dir
                              JOIN cargos c ON c.cod_cargo = r.cod_cargo
                              JOIN instituciones i ON r.cod_ies_padre = i.cod_ies_padre";
                    if ($search) {
                        $query .= " WHERE d.nombre ILIKE :search";
                    }
                    $query .= " LIMIT :limit OFFSET :offset";
                    $stmt = $conn->prepare($query);
                    if ($search) {
                        $stmt->bindValue(':search', "%$search%");
                    }
                    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
                    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
                    $stmt->execute();
                    $i = $offset + 1; // Para numerar los registros correctamente

                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr class='bg-white border-b hover:bg-gray-100'>"
                            . "<td class='py-2 px-4'>{$i}</td>"
                            . "<td class='py-2 px-4'>{$row['cod_dir']}</td>"
                            . "<td class='py-2 px-4'>{$row['nombre']}</td>"
                            . "<td class='py-2 px-4'>{$row['apellido']}</td>"
                            . "<td class='py-2 px-4'>{$row['cargo']}</td>"
                            . "<td class='py-2 px-4'>{$row['nomb_inst']}</td>"
                            . "<td class='py-2 px-4'>"
                            . "<a href='edit.php?cod_dir={$row['cod_dir']}' class='text-blue-500 hover:text-blue-700 mr-2'><i class='fas fa-edit'></i></a>"
                            . "<a href='delete.php?cod_dir={$row['cod_dir']}' class='text-red-500 hover:text-red-700'><i class='fas fa-trash'></i></a>"
                            . "</td>"
                            . "</tr>";
                        $i++;
                    }
                } catch (PDOException $e) {
                    echo "Error en la base de datos: " . $e->getMessage();
                    exit();
                }
                ?>
                <?php if ($total == 0): ?>
                    <tr>
                        <td colspan="7" class="py-2 px-4 border-b text-center">No se encontraron resultados</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <div class="mt-4 flex justify-between items-center">
            <a href="add_directivo.php" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                <i class="fas fa-plus"></i> Añadir Directivo
            </a>
            <div>
                <?php
                $range = 2; // Número de páginas a mostrar a cada lado de la página actual
                $start = max(1, $page - $range);
                $end = min($totalPages, $page + $range);

                if ($page > 1) {
                    echo '<a href="?page=1&search=' . urlencode($search) . '" class="px-4 py-2 border bg-white text-blue-500">Primero</a>';
                    echo '<a href="?page=' . ($page - 1) . '&search=' . urlencode($search) . '" class="px-4 py-2 border bg-white text-blue-500">Anterior</a>';
                }

                for ($i = $start; $i <= $end; $i++) {
                    if ($i == $page) {
                        echo '<span class="px-4 py-2 border bg-blue-500 text-white">' . $i . '</span>';
                    } else {
                        echo '<a href="?page=' . $i . '&search=' . urlencode($search) . '" class="px-4 py-2 border bg-white text-blue-500">' . $i . '</a>';
                    }
                }

                if ($page < $totalPages) {
                    echo '<a href="?page=' . ($page + 1) . '&search=' . urlencode($search) . '" class="px-4 py-2 border bg-white text-blue-500">Siguiente</a>';
                    echo '<a href="?page=' . $totalPages . '&search=' . urlencode($search) . '" class="px-4 py-2 border bg-white text-blue-500">Último</a>';
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>