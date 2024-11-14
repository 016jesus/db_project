<?php
session_start();
include_once "../../connect.php";
include_once "../../validation.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit']) && $_POST['submit'] === 'true') {
    $nombre = trim($_POST['nombre']);
    $apellido = trim($_POST['apellido']);
    $cargo = $_POST['cargo'];
    $institucion = $_POST['institucion'];

    if (!validateText($nombre) || !validateText($apellido) || empty($cargo) || empty($institucion)) {
        $_SESSION['mensaje'] = "<p class='text-red-500'>Todos los campos son obligatorios y deben ser válidos.</p>";
        header("Location: add_directivo.php");
        exit();
    }

    try {
        $conn->beginTransaction();
        $query = "INSERT INTO directivos (nombre, apellido) VALUES (:nombre, :apellido)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindParam(':apellido', $apellido, PDO::PARAM_STR);
        $stmt->execute();
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