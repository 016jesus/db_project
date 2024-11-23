<?php
session_start();
include_once "../../connect.php";

// Verificar si el usuario está autenticado
if (!isset($_SESSION['dbuser'])) {
    header("Location: ../login/login.php");
    exit();
}

try {
    // Consulta para obtener los registros de autoria
    $query = "SELECT * FROM privado.registro_autoria";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $registros = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Error connecting to the database: " . $e->getMessage();
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registros de Autoria</title>
    <script src="../media/style.js"></script>
    <link rel="stylesheet" href="../media/style.css">
</head>
<body class="bg-gray-100">
<?php 
    include_once "../main/header.php";
?>
    <div class="container mx-auto mt-10">
        <div class="bg-gray-800 text-white p-4 flex justify-between items-center">
            <h2 class="text-2xl">Registros de Autoria</h2>
            <a href="../main/index.php" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                <i class="fas fa-home"></i> Inicio
            </a>
        </div>
        <div class="bg-white p-6 rounded shadow-md mt-4">
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b">ID</th>
                        <th class="py-2 px-4 border-b">Nombre</th>
                        <th class="py-2 px-4 border-b">Descripción</th>
                        <th class="py-2 px-4 border-b">Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($registros as $registro): ?>
                        <tr class="bg-white border-b hover:bg-gray-100">
                            <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($registro['id']); ?></td>
                            <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($registro['nombre']); ?></td>
                            <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($registro['descripcion']); ?></td>
                            <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($registro['fecha']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>