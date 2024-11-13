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
        <?php 
        session_start();
        include_once "header.php";
        include_once "../atributtes.php"; 
        ?>

        <div class="mt-4">
            <div class="flex justify-between items-center p-4 bg-gray-800 text-white">
                <h2 class="text-2xl">Consulta de Instituciones</h2>
                <div>
                    <a href="login.php" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Iniciar Sesión</a>
                    <a href="registro.php" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 ml-2">Registrar</a>
                </div>
            </div>

            <div class="flex mt-4">
                <!-- Sección de filtros -->
                <form id="filterForm" method="POST" action="results.php" class="w-1/4 bg-white shadow-md p-4">
                    <h3 class="text-lg font-bold mb-4">Seleccione los filtros para la búsqueda</h3>
                    
                        <div class="flex items-center space-x-2">
                            <label for="records">Mostrar:</label>
                             <select name="limit" class="border border-gray-300 p-2 rounded">
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="Todos">Todos</option>
                            </select>
                            <span class="text-gray-700">registros</span>
                        </div>
                    <br>
                    <div class="mb-4">
                        <label class="block text-gray-700">Nombre de la Institución</label>
                        <input type="text" name="nombre_inst" class="w-full border border-gray-300 p-2 rounded">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700">Código de la Institución</label>
                        <input type="text" name="codigo_inst" class="w-full border border-gray-300 p-2 rounded">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700">Departamento</label>
                        <select name="departamento" class="w-full border border-gray-300 p-2 rounded">
                            <option value="all">Todos</option>
                            <?php
                            include_once "../connect.php";
                            $query = "SELECT * FROM departamentos";
                            $result = $conn->query($query);
                            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                echo "<option value='{$row['cod_depto']}'>{$row['nomb_depto']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-4">
                        <h4 class="font-bold">Tipo de institución</h4>
                        <div class="mt-2">
                            <label class="block text-gray-700">Estado de la Institución</label>
                            <div class="mt-1">
                                <label class="inline-flex items-center">
                                    <input type="radio" class="form-radio" name="estado" value="all" checked>
                                    <span class="ml-2">Todos</span>
                                </label>
                                <label class="inline-flex items-center ml-4">
                                    <input type="radio" class="form-radio" name="estado" value="true">
                                    <span class="ml-2">Activo (<?php echo $nactiva;?>)</span>
                                </label>
                                <label class="inline-flex items-center ml-4">
                                    <input type="radio" class="form-radio" name="estado" value="false">
                                    <span class="ml-2">Inactiva (<?php echo $ninactiva;?>)</span>
                                </label>
                            </div>
                        </div>
                        <div class="mt-2">
                            <label class="block text-gray-700">Tipo de sede</label>
                            <div class="mt-1">
                                <label class="inline-flex items-center ml-4">
                                    <input type="radio" class="form-radio" name="sede" value="all" checked>
                                    <span class="ml-2">Todos</span>
                                </label>
                                <br>
                                <label class="inline-flex items-center ml-4">
                                    <input type="radio" class="form-radio" name="sede" value="false">
                                    <span class="ml-2">Principal (<?php echo $nno_seccional ?>)</span>
                                </label>
                                <br>
                                <label class="inline-flex items-center ml-4">
                                    <input type="radio" class="form-radio" name="sede" value="true">
                                    <span class="ml-2">Seccional (<?php echo $nseccional ?>)</span>
                                </label>
                            </div>
                        </div>
                        
                        <div class="mt-2">
                            <label class="block text-gray-700">Caracter Academico</label>
                            <div class="mt-1">
                                <label class="inline-flex items-center ml-4">
                                    <input type="radio" class="form-radio" name="caracter_acad" value="all" checked>
                                    <span class="ml-2">Todos</span>
                                </label>

                                <?php
                                $query = "select * from caracter_academico";
                                $result = $conn->query($query);
                                while($row = $result->fetch(PDO::FETCH_ASSOC)){
                                    echo "
                                    <br>
                                    <label class='inline-flex items-center ml-4'>
                                    <input type='radio' class='form-radio' name='caracter_acad' value='{$row['cod_acad']}'>
                                    <span class='ml-2'>{$row['nomb_acad']}</span>
                                    </label>";
                                }

                                ?>
                            </div>
                        </div>
                        <div class="mt-2">
                        <label class="block text-gray-700">Acto Administrativo</label>
                        <select name="cod_admin" class="w-full border border-gray-300 p-2 rounded">
                            <option value="all">Todos</option>
                        <?php
                                $query = "select * from acto_administrativo";
                                $result = $conn->query($query);
                                while($row = $result->fetch(PDO::FETCH_ASSOC)){
                                    echo "<option value='{$row['cod_admin']}'>{$row['nomb_admin']}</option>";
                                }
                                
                                ?>
                        </select>
                        </div>


                    </div>
                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">Buscar</button>
                </form>

                <!-- Sección de resultados -->
                <div class="w-3/4 ml-4">
                    
                    <table class="min-w-full bg-white mt-4">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 border-b">#</th>
                                <th class="py-2 px-4 border-b">Nombre IES</th>
                                <th class="py-2 px-4 border-b">Código IES</th>
                                <th class="py-2 px-4 border-b">IES padre</th>
                                <th class="py-2 px-4 border-b">Sector</th>
                                <th class="py-2 px-4 border-b">Caracter Academico</th>
                                <th class="py-2 px-4 border-b">Activa</th>
                                <th class="py-2 px-4 border-b">Seccional</th>
                                <th class="py-2 px-4 border-b">Departamento/Municipio</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $continue = $_SESSION['continue'];
                            if($continue == true){
                                if($_SESSION['salida'] == ""){
                                    echo "<tr><td colspan='6' class='py-2 px-4 border-b text-center'>No se encontraron resultados</td></tr>";
                                } else {
                                    $salida = $_SESSION['salida'];
                                    $limit = isset($_SESSION['fin']) ? $_SESSION['fin'] : 10;
                                    $inicio = isset($_SESSION['inicio']) ? $_SESSION['inicio'] : 0;
                                     for($i = $inicio; $i <= $limit; $i++){
                                         echo $salida[$i];
                                     }
                                }
                            } else {
                                $query = $_SESSION['query'];
                                $result = $conn->query($query);
                                $limit = 10;
                                for($i = 1; $i <= $limit; $i++){
                                    $row['seccional'] = $row['seccional'] == 1 ? 'Seccional' : 'Principal';
                                    $row['activa'] = $row['activa'] == 1 ? 'Activa' : 'Inactiva';
                                    $row['publica'] = $row['publica'] == 1 ? 'Publico' : 'Privado';
                                    $row = $result->fetch(PDO:: FETCH_ASSOC);
                                    echo "<tr>"
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
                                }

                            }
                            ?>
                        </tbody>
                    </table>
                <div class="bg-white shadow-md p-4 mt-4 flex justify-between items-center">
                        <span class="text-gray-700"><?php echo "Mostrando " .$_SESSION['inicio']. " a " .$_SESSION['fin']." de ".$_SESSION['results'] ." instituciones coincidentes"; ?></span>
                        <div class="flex space-x-2">
                            <?php
                                    $limit = $_SESSION['limit'] ?? 0;
                                    $results = $_SESSION['results'] ?? 0;
                                    $current_page = $_GET['page'] ?? 1;
                                    $pages = ceil($results / $limit);
                                    $max_buttons = 5; // Número máximo de botones de paginación visibles

                                    $start_page = max(1, $current_page - floor($max_buttons / 2));
                                    $end_page = min($pages, $start_page + $max_buttons - 1);

                                    if ($end_page - $start_page < $max_buttons - 1) {
                                        $start_page = max(1, $end_page - $max_buttons + 1);
                                    }
                                    ?>

                                    <div class="bg-white shadow-md p-4 mt-4 flex justify-between items-center">
                                        <span class="text-gray-700"><?php echo "Mostrando " .$_SESSION['inicio']. " a " .$_SESSION['fin']." de ".$_SESSION['results'] ." instituciones coincidentes"; ?></span>
                                        <div class="flex space-x-2">
                                            <?php if ($current_page > 1): ?>
                                                <a href="?page=<?php echo $current_page - 1; ?>" class="bg-gray-300 text-gray-700 px-4 py-2 rounded">Anterior</a>
                                            <?php endif; ?>

                                            <?php for ($i = $start_page; $i <= $end_page; $i++): ?>
                                                <a href="?page=<?php echo $i; ?>" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 ml-2 <?php echo $i == $current_page ? 'bg-blue-700' : ''; ?>"><?php echo $i; ?></a>
                                            <?php endfor; ?>

                                            <?php if ($current_page < $pages): ?>
                                                <a href="?page=<?php echo $current_page + 1; ?>" class="bg-gray-300 text-gray-700 px-4 py-2 rounded">Siguiente</a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                        </div>
                    </div>
                    <div class="bg-white shadow-md p-4 mt-4">
                        <p class="text-gray-700 text-sm">NOTA: La información aquí contenida corresponde a los datos de caracterización de la personería jurídica otorgada a la Institución de Educación Superior y a los programas académicos que oferta la Institución de Educación Superior a través del sistema SACES (Soporte al Aseguramiento de la Calidad de la Educación Superior).</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>