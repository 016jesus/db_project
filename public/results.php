<?php


include_once "../connect.php";


session_start();

$_SESSION['query'] = "SELECT * FROM inst_por_mun i
                            JOIN 
                                cobertura c ON i.cod_inst = c.cod_inst
                            JOIN 
                                municipios m ON c.cod_munic = m.cod_munic
                            JOIN 
                                departamentos d ON m.cod_depto = d.cod_depto
                            JOIN 
                                instituciones ins ON i.cod_ies_padre = ins.cod_ies_padre
                            JOIN
                                caracter_academico ca ON ins.cod_acad = ca.cod_acad";                            
        
$_SESSION['continue'] = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    
    // variable de control
    $_SESSION['continue'] = true;


    $limit = $_POST['limit'];
    $estado = $_POST['estado'] === 'all' ? null : $_POST['estado'];
    $sede = $_POST['sede'] === 'all' ? null : $_POST['sede'];

    $nombre_inst = $_POST['nombre_inst'] == '' ? null : $_POST['nombre_inst'];
    $codigo_inst = $_POST['codigo_inst'] == '' ? null : $_POST['codigo_inst'];
    $departamento = $_POST['departamento'];
    $caracter_acad = $_POST['caracter_acad'];


    $host  = $_SERVER['HTTP_HOST'];
    $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    $extra = 'index.php';

    // consulta sql
    $query = $_SESSION['query'] . " WHERE 1=1";
    
    if ($estado !== null) {
        $query .= " AND activa = $estado";
    }

    if ($sede !== null) {
        $query .= " AND seccional = $sede";
    }

    if ($codigo_inst !== null) {
        $query .= " AND i.cod_inst = $codigo_inst";
    }

    if ($nombre_inst !== null) {
        $query .= " AND ins.nomb_inst ILIKE '%$nombre_inst%'";
    }

    if($departamento != 'all'){
        $query .= " AND d.cod_depto = $departamento";
    }

    if($caracter_acad !== 'all'){
        $query .= " AND ca.cod_acad = $caracter_acad";
    }






    

    echo $query;
    $result = $conn->query($query);
    $limit = $limit == 'Todos' ? $result->rowCount(): $limit;
    $salida = array();
    $i = 1;
    while (($row = $result->fetch(PDO::FETCH_ASSOC)) && $i <= $limit) {
        $row['seccional'] = $row['seccional'] == 1 ? 'Seccional' : 'Principal';
        $row['activa'] = $row['activa'] == 1 ? 'Activa' : 'Inactiva';
        $row['publica'] = $row['publica'] == 1 ? 'Publico' : 'Privado';
        $salida[$i]= "<tr>"
            . "<td class='py-2 px-4 border-b'>{$i}</td>"
            . "<td class='py-2 px-4 border-b'><a href='https://{$row['pagina_web']}' class='text-blue-500' target='_blank'>{$row['nomb_inst']}</a></td>"
            . "<td class='py-2 px-4 border-b'>{$row['cod_inst']}</td>"
            . "<td class='py-2 px-4 border-b'>{$row['cod_ies_padre']}</td>"
            . "<td class='py-2 px-4 border-b'>{$row['publica']}</td>"
            . "<td class='py-2 px-4 border-b'>{$row['nomb_acad']}</td>"
            . "<td class='py-2 px-4 border-b'>{$row['activa']}</td>"
            . "<td class='py-2 px-4 border-b'>{$row['seccional']}</td>"
            . "<td class='py-2 px-4 border-b'>{$row['nomb_depto']}/{$row['nomb_munic']}</td>"
            . "</tr>";
            $i++;
    }
    $_SESSION['inicio'] = 1;
    $_SESSION['limit'] = $_SESSION['inicio'] + $limit;
    $_SESSION['results'] = $result->rowCount();
    $_SESSION['salida'] = $salida;
    //echo $salida[1];
    header("Location: http://$host$uri/$extra");
    exit;
}
