<?php
include_once "../../connect.php";
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Directivo</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto mt-10">
        <div class="bg-white p-6 rounded shadow-md">
            <?php
            if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                $cod_dir = $_GET['cod_dir'];

                if (isset($_GET['confirm']) && $_GET['confirm'] == 'yes') {
                    // SQL para eliminar un registro
                    $sql = "DELETE FROM directivos WHERE cod_dir = $cod_dir";
                
                    if ($conn->query($sql)) {
                        echo "<div class='bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative' role='alert'>
                                <span class='block sm:inline'>Registro eliminado exitosamente.</span>
                              </div>";
                        sleep(2);
                        header("Location: directivos.php");
                        exit();
                    } else {
                        echo "<div class='bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative' role='alert'>
                                <span class='block sm:inline'>Error al eliminar el registro: " . $conn->errorInfo() . "</span>
                              </div>";
                    }

                } elseif (isset($_GET['confirm']) && $_GET['confirm'] == 'no') {
                    echo "<div class='bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative' role='alert'>
                            <span class='block sm:inline'>Operación cancelada.</span>
                          </div>";

                
                    sleep(2);
                    header("Location: directivos.php");
                    exit();
                } else {
                    // Obtener el nombre y apellido del directivo
                    $sql = "SELECT nombre, apellido FROM directivos WHERE cod_dir = $cod_dir";
                    $stmt = $conn->query($sql);
                    $directivo = $stmt->fetch(PDO::FETCH_ASSOC);
                    $nombre = htmlspecialchars($directivo['nombre']);
                    $apellido = htmlspecialchars($directivo['apellido']);
                    echo "
                    <form method='GET' action='delete.php' class='bg-white p-6 rounded shadow-md'>
                        <input type='hidden' name='cod_dir' value='$cod_dir'>
                        <p class='text-gray-700'>¿Está seguro de que desea eliminar este directivo?: <strong>$nombre $apellido</strong></p>
                        <div class='mt-4'>
                            <input type='submit' name='confirm' value='yes' class='bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600'> Sí
                            <input type='submit' name='confirm' value='no' class='bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 ml-2'> No
                        </div>
                    </form>
                    ";
                }
            } else {
                echo "<div class='bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative' role='alert'>
                        <span class='block sm:inline'>Método de solicitud no válido.</span>
                      </div>";
            }
            ?>
        </div>
    </div>
</body>
</html>
