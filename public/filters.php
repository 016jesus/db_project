<!-- archivo de los filtros de estado, tipo de sede, caracter academico, y sector -->



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


    <?php include_once "filter_options.php"; ?>
</div>


<div class="w-3/4 ml-4">
    <div class="bg-white shadow-md p-4 flex justify-between items-center">
        <!-- <button class="bg-green-500 text-white px-4 py-2 rounded">Descargar instituciones</button> -->
        <div class="flex items-center space-x-2">

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
        </div>
    </div>



</form>