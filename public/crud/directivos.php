<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD de Directivos</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto">
        <?php 
        session_start();
        include_once "../main/header.php";
        include_once "../../atributtes.php"; 
        ?>
        <div class="mt-4">
            <div class="flex justify-between items-center p-4 bg-gray-800 text-white">
                <h2 class="text-2xl">CRUD de Directivos</h2>
                <div>
                    <a href="index.php" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Inicio</a>
                </div>
                <div class="mb-4">
                    <p><?php echo "Hola, ".$_SESSION['username']; ?></p>
                </div>
            </div>

            <div class="flex mt-4">
                <div class="w-full bg-white shadow-md p-4">
                    <form method="GET" action="directivos.php" class="mb-4">
                        <div class="flex items-center">
                            <input type="text" name="search" placeholder="Buscar por nombre" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 ml-2">Buscar</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="flex mt-4">
                <div class="w-full">
                    <table class="min-w-full bg-white mt-4">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 border-b">#</th>
                                <th class="py-2 px-4 border-b">Código</th>
                                <th class="py-2 px-4 border-b">Nombre</th>
                                <th class="py-2 px-4 border-b">Apellido</th>
                                <th class="py-2 px-4 border-b">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include_once "../../connect.php";

                            // Configuración de la paginación
                            $limit = 10; // Número de registros por página
                            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Página actual
                            $offset = ($page - 1) * $limit; // Offset para la consulta

                            // Filtro de búsqueda
                            $search = isset($_GET['search']) ? strtoupper(trim($_GET['search'])) : '';

                            // Consulta para contar el total de registros
                            $countQuery = "SELECT COUNT(*) as total FROM directivos";
                            if ($search) {
                                $countQuery .= " WHERE nombre ILIKE :search";
                            }
                            $countStmt = $conn->prepare($countQuery);
                            if ($search) {
                                $countStmt->bindValue(':search', "%$search%");
                            }
                            $countStmt->execute();
                            $total = $countStmt->fetch(PDO::FETCH_ASSOC)['total'];
                            $totalPages = ceil($total / $limit); // Total de páginas

                            // Consulta para obtener los registros de la página actual
                            $query = "SELECT * FROM directivos";
                            if ($search) {
                                $query .= " WHERE nombre LIKE :search";
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
                                echo "<tr>"
                                    . "<td class='py-2 px-4 border-b'>{$i}</td>"
                                    . "<td class='py-2 px-4 border-b'>{$row['cod_dir']}</td>"
                                    . "<td class='py-2 px-4 border-b'>{$row['nombre']}</td>"
                                    . "<td class='py-2 px-4 border-b'>{$row['apellido']}</td>"
                                    . "<td class='py-2 px-4 border-b'>"
                                    . "<a href='edit.php?cod_dir={$row['cod_dir']}' class='text-blue-500'><i class='fas fa-edit'></i> Editar</a> | "
                                    . "<a href='delete.php?cod_dir={$row['cod_dir']}' class='text-red-500'><i class='fas fa-trash'></i> Eliminar</a>"
                                    . "</td>"
                                    . "</tr>";
                                $i++;
                            }
                            ?>
                        </tbody>
                    </table>
                    <div class="flex justify-center mt-4">
                        <a href="add_directivo.php" class="bg-green-500 text-white px-4 py-2 rounded-full hover:bg-green-600 flex items-center">
                            <i class="fas fa-plus mr-2"></i> Agregar Nuevo Directivo
                        </a>
                    </div>
                    <div class="flex justify-center mt-4">
                        <nav>
                            <ul class="flex space-x-2">
                                <?php if ($page > 1): ?>
                                    <li>
                                        <a href="?page=1<?php echo $search ? '&search=' . urlencode($search) : ''; ?>" class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400">Primera</a>
                                    </li>
                                    <li>
                                        <a href="?page=<?php echo $page - 1; ?><?php echo $search ? '&search=' . urlencode($search) : ''; ?>" class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400">Anterior</a>
                                    </li>
                                <?php endif; ?>

                                <?php
                                // Mostrar un rango de botones de paginación
                                $start = max(1, $page - 2);
                                $end = min($totalPages, $page + 2);

                                for ($i = $start; $i <= $end; $i++): ?>
                                    <li>
                                        <a href="?page=<?php echo $i; ?><?php echo $search ? '&search=' . urlencode($search) : ''; ?>" class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400 <?php echo $i === $page ? 'bg-blue-500 text-white' : ''; ?>"><?php echo $i; ?></a>
                                    </li>
                                <?php endfor; ?>

                                <?php if ($page < $totalPages): ?>
                                    <li>
                                        <a href="?page=<?php echo $page + 1; ?><?php echo $search ? '&search=' . urlencode($search) : ''; ?>" class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400">Siguiente</a>
                                    </li>
                                    <li>
                                        <a href="?page=<?php echo $totalPages; ?><?php echo $search ? '&search=' . urlencode($search) : ''; ?>" class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400">Última</a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                    </div>
                    <div class="bg-white shadow-md p-4 mt-4">
                        <p class="text-gray-700 text-sm">NOTA: La información aquí contenida corresponde a los datos de los directivos registrados en la base de datos.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>