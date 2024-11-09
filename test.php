<?php
include_once('connect.php');
//phpinfo();


try {


    $conn = set_conn("apipassword");
    $sql = "SELECT cod_inst, i.cod_ies_padre, nit, ie.nomb_inst FROM inst_por_mun i JOIN instituciones ie ON i.cod_ies_padre = ie.cod_ies_padre ORDER BY i.cod_inst";
    $stmt = $conn->query($sql);

//lunes 18 examen final
    
echo "";
    echo "<table border='1'>";
     
    echo "<tr><th>cod_inst</th><th>cod_ies_padre</th><th>nit</th><th>nombre<th></tr>";

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        foreach ($row as $column) {
            echo "<td>" . htmlspecialchars($column) . "</td>";
        }
        echo "</tr>";
    }
    echo "</table>";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$conn = null;

