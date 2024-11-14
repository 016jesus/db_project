<?php
session_start();
include_once "../connect.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit']) && $_POST['submit'] === 'true') {
    $nombre = trim($_POST['nombre']);
    $apellido = trim($_POST['apellido']);
    $cargo = $_POST['cargo'];
    $institucion = $_POST['institucion'];

    // Validación en el servidor
    if (empty($nombre) || empty($apellido) || empty($cargo) || empty($institucion)) {
        $_SESSION['mensaje'] = "<p class='text-red-500'>Todos los campos son obligatorios.</p>";
        header("Location: add_directivo.php");
        exit();
    }

    try {
        // Iniciar una transacción
        $conn->beginTransaction();

        // Consulta para insertar el nuevo directivo en la tabla `directivos`
        $query = "INSERT INTO directivos (nombre, apellido) VALUES (:nombre, :apellido)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellido', $apellido);
        $stmt->execute();

        // // Obtener el ID del directivo insertado
        // $cod_directivo = $conn->lastInsertId();

        // // Consulta para asignar el cargo y la institución al directivo en la tabla `rigen`
        // $query = "INSERT INTO rigen (cod_dir, cod_cargo, cod_ies_padre) VALUES (:cod_directivo, :cod_cargo, :cod_ies_padre)";
        // $stmt = $conn->prepare($query);
        // $stmt->bindParam(':cod_directivo', $cod_directivo);
        // $stmt->bindParam(':cod_cargo', $cargo); // Asegúrate de que este valor corresponda con la clave primaria en la tabla `cargos`
        // $stmt->bindParam(':cod_ies_padre', $institucion); // Asegúrate de que este valor corresponda con la clave primaria en la tabla `instituciones`
        // $stmt->execute();

        // // Confirmar la transacción
        // $conn->commit();

        // $_SESSION['mensaje'] = "<p class='text-green-500'>Directivo agregado y asignado exitosamente.</p>";
    } catch (Exception $e) {
        // Revertir la transacción en caso de error
        $conn->rollBack();
        $_SESSION['mensaje'] = "<p class='text-red-500'>Error al agregar el directivo: " . $e->getMessage() . "</p>";
    }

    header("Location: add_directivo.php");
    exit();
}
?>
