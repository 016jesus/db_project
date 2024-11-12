<!-- archivo principal de la web -->

<?php 

// incluye la configuración de la base de datos y la conexion
include_once "../atributtes.php"; 
session_start();
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Instituciones</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto">

        <?php include_once "header.php"; ?>

        <div class="mt-4">
            <div class="bg-gray-800 text-white p-4">
                <h2 class="text-2xl">Consulta de Instituciones</h2>
                <p>Sistema Nacional de Información para la Educación superior en Colombia</p>
            </div>

            <div class="flex mt-4">
                <!-- seccion de filtros -->


                <?php  include_once "filters.php"; ?>

                <!-- seccion de resultados -->
                <table class="min-w-full bg-white">
                            <thead>
                                <tr>
                                    <th class="py-2 px-4 border-b">#</th>
                                    <th class="py-2 px-4 border-b">Nombre IES</th>
                                    <th class="py-2 px-4 border-b">Código IES</th>
                                    <th class="py-2 px-4 border-b">IES padre</th>
                                    <th class="py-2 px-4 border-b">Activa</th>
                                    <th class="py-2 px-4 border-b">Seccional</th>
                                    <!-- <th class="py-2 px-4 border-b">Sector</th>
                                    <th class="py-2 px-4 border-b">Carácter académico</th>
                                    <th class="py-2 px-4 border-b">Departamento / Municipio</th>
                                    <th class="py-2 px-4 border-b">Estado IES</th>
                                    <th class="py-2 px-4 border-b">Programas vigentes</th>
                                    <th class="py-2 px-4 border-b">Programas en convenio</th>
                                    <th class="py-2 px-4 border-b">¿Acreditada?</th> -->
                                </tr>
                            </thead>
                    <tbody>
                        <?php
             
                            
                            
                            $continue = $_SESSION['continue'];
                            if($continue == true){
                                if($_SESSION['salida'] == ""){
                                    echo "<tr><td>No se encontraron resultados </td></tr>";
                                }else{
                                echo $_SESSION['salida'];
                            }
                        } 
                            else{
                                //mostrar salida por defecto

                                $query = "SELECT * FROM inst_por_mun i 
                                JOIN instituciones ins ON i.cod_ies_padre = ins.cod_ies_padre  
                                WHERE 1=1";
                                $result = $conn->query($query);
                                $limit = 10;
                                for($i = 0; $i < $limit; $i++){
                                    $row = $result->fetch(PDO:: FETCH_ASSOC);
                                    echo "<tr>"
                                    . "<td class='py-2 px-4 border-b'>{$i}</td>"
                                    ."<td class='py-2 px-4 border-b'><a href=" ."'https://". $row['pagina_web'] ."'". "class='text-blue-500' target = '_blank'>{$row['nomb_inst']}</a></td>"
                                    . "<td class='py-2 px-4 border-b'>{$row['cod_inst']}</td>"
                                    . "<td class='py-2 px-4 border-b'>{$row['cod_ies_padre']}</td>"
                                    ."<td class='py-2 px-4 border-b'>{$row['activa']}</td>"
                                    ."<td class='py-2 px-4 border-b'>{$row['seccional']}</td>"
                                    // . "<td class='py-2 px-4 border-b'>{$row['sector']}</td>"
                                    // . "<td class='py-2 px-4 border-b'>{$row['cod_acad']}</td>"
                                    // . "<td class='py-2 px-4 border-b'>{$row['cod_mun']}</td>"
                                    // . "<td class='py-2 px-4 border-b'>{$row['actica']}</td>"
                                    // . "<td class='py-2 px-4 border-b'><a href='#' class='text-blue-500'>{$row['programas_vigentes']}</a></td>"
                                    // . "<td class='py-2 px-4 border-b'>{$row['programas_convenio']}</td>"
                                    //. "<td class='py-2 px-4 border-b'>{$row['acreditada']}</td>"
                                    . "</tr>";
                                }
                            }
                    
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
