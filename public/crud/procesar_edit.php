<?php
session_start();
include_once "../../connect.php";
include_once "../../validation.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit']) && $_POST['submit'] === 'true') {
    $cod_dir = $_SESSION['cod_dir'];
    $nombre = trim($_POST['nombre']);
    $apellido = trim($_POST['apellido']);
    $cargo = $_POST['cargo'];
    $cod_ies_padre = $_SESSION['cod_ies_padre']; // Obtener la institución desde la sesión

    if (!validateText($nombre) || !validateText($apellido) || empty($cargo)) {
        $_SESSION['mensaje'] = "<p class='text-red-500'>Todos los campos son obligatorios y deben ser válidos.</p>";
        header("Location: edit.php?cod_dir=$cod_dir");
        exit();
    }

    try {
        $conn->beginTransaction();

        // Verificar si el cargo ya está ocupado por otro directivo en la misma institución
        $query = "SELECT COUNT(*) FROM rigen r
                  JOIN directivos d ON r.cod_dir = d.cod_dir
                  WHERE r.cod_cargo = :cargo AND r.cod_dir != :cod_dir AND d.cod_ies_padre = :cod_ies_padre";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':cargo', $cargo, PDO::PARAM_INT);
        $stmt->bindParam(':cod_dir', $cod_dir, PDO::PARAM_INT);
        $stmt->bindParam(':cod_ies_padre', $cod_ies_padre, PDO::PARAM_INT);
        $stmt->execute();
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            $_SESSION['mensaje'] = "<p class='text-red-500'>El cargo seleccionado ya está ocupado por otro directivo en la misma institución.</p>";
            header("Location: edit.php?cod_dir=$cod_dir");
            exit();
        }

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

        $conn->commit();
        $_SESSION['mensaje'] = "<p class='text-green-500'>Directivo actualizado exitosamente.</p>";
        header("Location: directivos.php");
        exit();
    } catch (PDOException $e) {
        $conn->rollBack();
        $_SESSION['mensaje'] = "<p class='text-red-500'>Error en la base de datos: " . $e->getMessage() . "</p>";
        header("Location: edit.php?cod_dir=$cod_dir");
        exit();
    }
}
?>