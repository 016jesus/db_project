<?php




include_once "../connect.php";


session_start();
$_SESSION['continue'] = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    
    // variable de control
    $_SESSION['continue'] = true;
    $limit = $_POST['limit'];
    $estado = $_POST['estado'] === 'all' ? null : $_POST['estado'];
    $sede = $_POST['sede'] === 'all' ? null : $_POST['sede'];
    // consulta sql
    $query = "SELECT * FROM inst_por_mun i 
    JOIN instituciones ins ON i.cod_ies_padre = ins.cod_ies_padre  
    WHERE 1=1";
    
    if ($estado !== null) {
        $query .= " AND activa = $estado";
    }

    if ($sede !== null) {
        $query .= " AND seccional = $sede";
    }

    if ($limit != "Todos") {
        $query .= " LIMIT $limit";
    }
    
    $result = $conn->query($query);
    $salida = "";
    $i = 0;
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $i++;
        $row['seccional'] = $row['seccional'] == 1 ? 'Seccional' : 'Principal';
        $row['activa'] = $row['activa'] == 1 ? 'Activa' : 'Inactiva';
        $salida .="<tr>"
                . "<td class='py-2 px-4 border-b'>{$i}</td>"
                ."<td class='py-2 px-4 border-b'><a href='#' class='text-blue-500'>{$row['nomb_inst']}</a></td>"
                . "<td class='py-2 px-4 border-b'>{$row['cod_inst']}</td>"
                . "<td class='py-2 px-4 border-b'>{$row['cod_ies_padre']}</td>"
                ."<td class='py-2 px-4 border-b'>{$row['activa']}</td>"
                ."<td class='py-2 px-4 border-b'>{$row['seccional']}</td>"
                ."</tr>";
    }
    $_SESSION['salida'] = $salida;
    $host  = $_SERVER['HTTP_HOST'];
    $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    $extra = 'index.php';
    header("Location: http://$host$uri/$extra");
    exit;
}
