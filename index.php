<html>
<head>
    <title>Consulta de Instituciones</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto">
        <!-- Header -->
        <?php include_once "atributtes.php"; ?>
        <div class="bg-white shadow-md p-4 flex justify-between items-center">
            <div class="flex items-center">
                <img src="https://storage.googleapis.com/a1aa/image/03Ph9VGQxAJLL9qlIisHpXrCyvd0UhpwFlyULnndHlYM207E.jpg" alt="SNIES Logo" class="mr-4" width="100" height="50">
                <div>
                    <h1 class="text-4xl font-bold text-red-600">SNIES</h1>
                    <p class="text-gray-600">Sistema Nacional de Información de la Educación Superior</p>
                </div>
            </div>
            <img src="https://storage.googleapis.com/a1aa/image/ni17LxcANpq7H5IfTLRw7nuSlFKHhn7iXrK3lbhtvXjXsp3JA.jpg" alt="Ministerio de Educación Logo" width="100" height="50">
        </div>

        <!-- Main Content -->
        <div class="mt-4">
            <div class="bg-gray-800 text-white p-4">
                <h2 class="text-2xl">Consulta de Instituciones</h2>
                <p>Sistema Nacional de Información para la Educación superior en Colombia</p>
            </div>

            <div class="flex mt-4">
                <!-- Filters Section -->
                <div class="w-1/4 bg-white shadow-md p-4">
                    <h3 class="text-lg font-bold mb-4">Seleccione los filtros para la búsqueda</h3>
                    <div class="mb-4">
                        <label class="block text-gray-700">Nombre de la Institución</label>
                        <input type="text" class="w-full border border-gray-300 p-2 rounded">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700">Código de la Institución</label>
                        <input type="text" class="w-full border border-gray-300 p-2 rounded">
                    </div>
                    <div class="flex space-x-2 mb-4">
                        <button class="bg-blue-500 text-white px-4 py-2 rounded">Buscar</button>
                        <button class="bg-yellow-500 text-white px-4 py-2 rounded">Limpiar</button>
                    </div>
                    <div class="mb-4">
                        <h4 class="font-bold">Tipo de institución</h4>
                        <div class="mt-2">
                            <label class="block text-gray-700">Estado de la Institución</label>
                            <div class="mt-1">
                                <label class="inline-flex items-center">
                                    <input type="radio" class="form-radio" name="estado" checked>
                                    <span class="ml-2">Todos</span>
                                </label>
                                <label class="inline-flex items-center ml-4">
                                    <input type="radio" class="form-radio" name="estado">
                                    <span class="ml-2">Activo (<?php echo $nactiva;?>)</span>
                                </label>
                                <label class="inline-flex items-center ml-4">
                                    <input type="radio" class="form-radio" name="estado">
                                    <span class="ml-2">Inactiva (<?php echo $ninactiva;?>)</span>
                                </label>
                            </div>
                        </div>
                        <div class="mt-2">
                            <label class="block text-gray-700">Tipo de sede</label>
                            <div class="mt-1">
                                <label class="inline-flex items-center">
                                    <input type="radio" class="form-radio" name="sede" checked>
                                    <span class="ml-2">Todos</span>
                                </label>
                                <label class="inline-flex items-center ml-4">
                                    <input type="radio" class="form-radio" name="sede">
                                    <span class="ml-2">Principal (<?php echo $nno_seccional ?>)</span>
                                </label>
                                <label class="inline-flex items-center ml-4">
                                    <input type="radio" class="form-radio" name="sede">
                                    <span class="ml-2">Seccional (<?php echo $nseccional ?>)</span>
                                </label>
                            </div>
                        </div>
                        <div class="mt-2">
                            <label class="block text-gray-700">Carácter académico</label>
                            <div class="mt-1">
                                <label class="inline-flex items-center">
                                    <input type="radio" class="form-radio" name="caracter" checked>
                                    <span class="ml-2">Todos</span>
                                </label>
                                <label class="inline-flex items-center ml-4">
                                    <input type="radio" class="form-radio" name="caracter">
                                    <span class="ml-2">Institución Técnica Profesional (37)</span>
                                </label>
                                <label class="inline-flex items-center ml-4">
                                    <input type="radio" class="form-radio" name="caracter">
                                    <span class="ml-2">Institución Tecnológica (60)</span>
                                </label>
                                <label class="inline-flex items-center ml-4">
                                    <input type="radio" class="form-radio" name="caracter">
                                    <span class="ml-2">Institución Universitaria/Escuela Tecnológica (150)</span>
                                </label>
                                <label class="inline-flex items-center ml-4">
                                    <input type="radio" class="form-radio" name="caracter">
                                    <span class="ml-2">Universidad (142)</span>
                                </label>
                            </div>
                        </div>
                        <div class="mt-2">
                            <label class="block text-gray-700">Sector</label>
                            <div class="mt-1">
                                <label class="inline-flex items-center">
                                    <input type="radio" class="form-radio" name="sector" checked>
                                    <span class="ml-2">Todos</span>
                                </label>
                                <label class="inline-flex items-center ml-4">
                                    <input type="radio" class="form-radio" name="sector">
                                    <span class="ml-2">Pública (<?php echo $npublic?>)</span>
                                </label>
                                <label class="inline-flex items-center ml-4">
                                    <input type="radio" class="form-radio" name="sector">
                                    <span class="ml-2">Privada (<?php echo $npriv?>)</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Results Section -->
                <div class="w-3/4 ml-4">
                    <div class="bg-white shadow-md p-4 flex justify-between items-center">
                        <button class="bg-green-500 text-white px-4 py-2 rounded">Descargar instituciones</button>
                        <div class="flex items-center space-x-2">
                            <label for="records" class="text-gray-700">Mostrar</label>
                            <form action="procesar.php" method="POST">
                                <label for="records">Selecciona el número de registros:</label>
                                <select id="records" name="records" class="border border-gray-300 p-2 rounded">
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                                <button type="submit">Enviar</button>
                            </form>

                            <span class="text-gray-700">registros</span>
                        </div>
                    </div>
                    <div class="bg-white shadow-md mt-4">
                        <table class="min-w-full bg-white">
                            <thead>
                                <tr>
                                    <th class="py-2 px-4 border-b">Nombre IES</th>
                                    <th class="py-2 px-4 border-b">Código IES</th>
                                    <th class="py-2 px-4 border-b">IES padre</th>
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

                                if ($conn == null){
                                    echo "something's broken <br>";
                                }
                                $limit = 10;
                                $query = "SELECT i.nomb_inst, ip.cod_inst, i.cod_ies_padre
                                FROM inst_por_mun ip JOIN instituciones i ON i.cod_ies_padre = ip.cod_ies_padre";
                                $result= $conn->query($query);
                            for($i = 0; $i < $limit; $i++){
                                    $row = $result->fetch(PDO:: FETCH_ASSOC);
                                    echo "<tr>"
                                    ."<td class='py-2 px-4 border-b'><a href='#' class='text-blue-500'>{$row['nomb_inst']}</a></td>"
                                    . "<td class='py-2 px-4 border-b'>{$row['cod_inst']}</td>"
                                    . "<td class='py-2 px-4 border-b'>{$row['cod_ies_padre']}</td>"
                                    // . "<td class='py-2 px-4 border-b'>{$row['sector']}</td>"
                                    // . "<td class='py-2 px-4 border-b'>{$row['cod_acad']}</td>"
                                    // . "<td class='py-2 px-4 border-b'>{$row['cod_mun']}</td>"
                                    // . "<td class='py-2 px-4 border-b'>{$row['actica']}</td>"
                                    // . "<td class='py-2 px-4 border-b'><a href='#' class='text-blue-500'>{$row['programas_vigentes']}</a></td>"
                                    // . "<td class='py-2 px-4 border-b'>{$row['programas_convenio']}</td>"
                                    //. "<td class='py-2 px-4 border-b'>{$row['acreditada']}</td>"
                                    . "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="bg-white shadow-md p-4 mt-4 flex justify-between items-center">
                        <span class="text-gray-700">Mostrando 1 a 10 de 389 instituciones</span>
                        <div class="flex space-x-2">
                            <button class="bg-gray-300 text-gray-700 px-4 py-2 rounded">Anterior</button>
                            <button class="bg-blue-500 text-white px-4 py-2 rounded">1</button>
                            <button class="bg-gray-300 text-gray-700 px-4 py-2 rounded">2</button>
                            <button class="bg-gray-300 text-gray-700 px-4 py-2 rounded">3</button>
                            <button class="bg-gray-300 text-gray-700 px-4 py-2 rounded">4</button>
                            <button class="bg-gray-300 text-gray-700 px-4 py-2 rounded">5</button>
                            <button class="bg-gray-300 text-gray-700 px-4 py-2 rounded">...</button>
                            <button class="bg-gray-300 text-gray-700 px-4 py-2 rounded">39</button>
                            <button class="bg-gray-300 text-gray-700 px-4 py-2 rounded">Siguiente</button>
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