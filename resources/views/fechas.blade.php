<div id="cronograma-view" class="container" style="display:none;">
    <h3 class="cronograma-title mb-4">Configuración del Cronograma Académico</h3>
    
    <form action="{{ route('eventos.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nombre" class="form-label-cronograma">Nombre del Evento</label>
            <input type="text" name="nombre" id="nombre" class="form-control form-control-cronograma" placeholder="Ejemplo: Matrícula Inicial" required>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="fecha_inicio" class="form-label-cronograma">Fecha de Inicio</label>
                <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control form-control-cronograma" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="fecha_fin" class="form-label-cronograma">Fecha de Fin</label>
                <input type="date" name="fecha_fin" id="fecha_fin" class="form-control form-control-cronograma" required>
            </div>
        </div>

        <div class="d-flex justify-content-between mt-4">
            <button type="button" class="btn btn-secondary" onclick="backToMainView()">⬅ Volver</button>
            <button type="submit" class="btn btn-save-cronograma">💾 Guardar Evento</button>
        </div>
    </form>
</div>

<script>
function showCronogramaView() {
    document.getElementById('main-view').style.display = 'none';
    document.getElementById('cronograma-view').style.display = 'block';
}

function backToMainView() {
    document.getElementById('cronograma-view').style.display = 'none';
    document.getElementById('main-view').style.display = 'block';
}
</script>
