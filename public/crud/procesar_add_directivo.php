<?php
session_start();
include_once "../../connect.php";
include_once "../../validation.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = trim($_POST['nombre']);
    $apellido = trim($_POST['apellido']);
    $cargo = $_POST['cargo'];
    $institucion = $_POST['institucion'];
    $cod_nombram = $_POST['cod_nombram'];

    if (!validateText($nombre) || !validateText($apellido) || empty($cargo) || empty($institucion) || empty($cod_nombram)) {
        $_SESSION['mensaje'] = "<p class='text-red-500'>Todos los campos son obligatorios y deben ser válidos.</p>";
        header("Location: add_directivo.php");
        exit();
    }

    try {
        $conn = connectDefault();

        // Verificar si el cargo ya está ocupado en la misma institución
        $query = "SELECT COUNT(*) FROM rigen WHERE cod_cargo = :cargo AND cod_ies_padre = :institucion";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':cargo', $cargo, PDO::PARAM_INT);
        $stmt->bindParam(':institucion', $institucion, PDO::PARAM_INT);
        $stmt->execute();
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            $_SESSION['mensaje'] = "<p class='text-red-500'>El cargo seleccionado ya está ocupado en la misma institución.</p>";
            header("Location: add_directivo.php");
            exit();
        }

        // Insertar el nuevo directivo
        $conn->beginTransaction();
        $query = "INSERT INTO directivos (nombre, apellido) VALUES (:nombre, :apellido)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindParam(':apellido', $apellido, PDO::PARAM_STR);
        $stmt->execute();
        $cod_dir = $conn->lastInsertId();

        // Asignar el cargo al directivo en la institución
        $query = "INSERT INTO rigen (cod_dir, cod_cargo, cod_ies_padre, cod_nombram) VALUES ($cod_dir, $cargo, $institucion, $cod_nombram)";
        $conn->query($query);


        $conn->commit();
        $_SESSION['mensaje'] = "<p class='text-green-500'>Directivo agregado exitosamente.</p>";
        header("Location: directivos.php");
        exit();
    } catch (PDOException $e) {
        $conn->rollBack();
        $_SESSION['mensaje'] = "<p class='text-red-500'>Error al agregar el directivo: " . $e->getMessage() . "</p>";
        header("Location: add_directivo.php");
        exit();
    }
}
?>