<!-- archivo de las opciones de los filtros -->
<form id="filterForm" method="POST" action="results.php">
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
                <label class="inline-flex items-center">
                    <input type="radio" class="form-radio" name="sede" value="all" checked>
                    <span class="ml-2">Todos</span>
                </label>
                <label class="inline-flex items-center ml-4">
                    <input type="radio" class="form-radio" name="sede" value="false">
                    <span class="ml-2">Principal (<?php echo $nno_seccional ?>)</span>
                </label>
                <label class="inline-flex items-center ml-4">
                    <input type="radio" class="form-radio" name="sede" value="true">
                    <span class="ml-2">Seccional (<?php echo $nseccional ?>)</span>
                </label>
            </div>
        </div>
    </div>
    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">Buscar</button>



