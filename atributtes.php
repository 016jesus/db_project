
<?php

include "connect.php";



function countPerBool($tabla, $columna, $valor, $conn) {
    $query = "SELECT COUNT(*) as total FROM $tabla WHERE $columna = :valor";
    $stmt = $conn->prepare($query);
    
    // Vincular el parámetro de la consulta
    $stmt->bindParam(':valor', $valor, PDO::PARAM_BOOL);
    
    // Ejecutar la consulta y verificar si fue exitosa
    if ($stmt->execute()) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    } else {
        echo "Error en la consulta: " . $stmt->errorInfo()[2];
        return 0;
    }
}



$npublic = countPerBool('instituciones', 'publica', true, $conn);
$npriv = countPerBool('instituciones', 'publica', false,$conn);

$nactiva = countPerBool('inst_por_mun', 'activa', true, $conn);
$ninactiva = countPerBool('inst_por_mun', 'activa', false, $conn);

$nseccional = countPerBool('inst_por_mun', 'seccional', true, $conn);
$nno_seccional = countPerBool('inst_por_mun', 'seccional', false, $conn);

echo $nseccional;

// echo $npublic;