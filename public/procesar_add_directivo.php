<?php
session_start();
include_once "../connect.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nombre']) && isset($_POST['apellido'])) {
    $nombre = trim($_POST['nombre']);
    $apellido = trim($_POST['apellido']);
    
    // Validación en el servidor
    if (empty($nombre) || empty($apellido)) {
        $_SESSION['mensaje'] = "<p class='text-red-500'>Todos los campos son obligatorios.</p>";
        header("Location: add_directivo.php");
        exit();
    }

    // Consulta para insertar el nuevo directivo
    $query = "INSERT INTO directivos (nombre, apellido) VALUES (:nombre, :apellido)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':apellido', $apellido);
    
    if ($stmt->execute()) {
        $_SESSION['mensaje'] = "<p class='text-green-500'>Directivo agregado exitosamente.</p>";
    } else {
        $_SESSION['mensaje'] = "<p class='text-red-500'>Error al agregar el directivo.</p>";
    }

    header("Location: add_directivo.php");
    exit();
}
?>