<div class="modal fade" id="modal{{$articu->id_articulo}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <div class="modal-dialog">
        <form action="{{url("evaluar_art",$articu->id_articulo)}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method("PUT")
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">ARTÍCULO</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="text-center text-green-400">
                        <H4 class="text-wrap text-break">{{$articu->titulo}}</H4>
                        <input class="" type="hidden" name="artid" value="{{$articu->id_articulo}}">
                        <p>-----------------------</p>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-7">
                            <h5 class="py-3">Respuesta de la Evaluación</h5>
                        </div>
                        <div class="col-5">
                            <select name="estado" class="form-control" id="estado-select-{{$articu->id_articulo}}">
                                <option value="0" selected="true" disabled="true">Seleccionar estado</option>
                                <option class="" value="1">Aceptar</option>
                                <option class="" value="2">Rechazar</option>
                                <option class="" value="5">Aceptar con cambios</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3" id="archivo-container-{{$articu->id_articulo}}" style="display: none;">
                        <label for="archivo-{{$articu->id_articulo}}" class="form-label">Subir archivo</label>
                        <input type="file" class="form-control" id="archivo-{{$articu->id_articulo}}" name="archivo" accept=".doc,.docx">
                        <p class="mb-3">El tamaño máximo del archivo debe ser de 5MB</p>
                    </div>

                    <div class="mb-3" id="carta-aceptacion-container-{{$articu->id_articulo}}" style="display: none;">
                        <label for="carta-aceptacion-{{$articu->id_articulo}}" class="form-label">Subir carta de aceptación</label>
                        <input type="file" class="form-control" id="carta-aceptacion-{{$articu->id_articulo}}" name="carta_aceptacion" accept=".pdf">
                        <p class="mb-3">El tamaño máximo del archivo debe ser de 5MB</p>
                    </div>

                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Aceptar</button>
                </div>

            </div>
        </form>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        function updateArchivoVisibility(selectElementId, cartaContainerId, archivoContainerId, cartaInputId, archivoInputId) {
            const selectElement = document.getElementById(selectElementId);
            const cartaContainer = document.getElementById(cartaContainerId);
            const archivoContainer = document.getElementById(archivoContainerId);
            const cartaInput = document.getElementById(cartaInputId);
            const archivoInput = document.getElementById(archivoInputId);

            if (selectElement.value == '1') { // Estado "Aceptar"
                cartaContainer.style.display = 'block';
                archivoContainer.style.display = 'none';
                archivoInput.value = '';
            } else if (selectElement.value == '5') { // Estado "Aceptar con cambios"
                archivoContainer.style.display = 'block';
                cartaContainer.style.display = 'none';
                cartaInput.value = '';
            } else {
                cartaContainer.style.display = 'none';
                archivoContainer.style.display = 'none';
                cartaInput.value = '';
                archivoInput.value = '';
            }
        }

        document.querySelectorAll('[id^=estado-select-]').forEach(select => {
            const id = select.id.split('-').pop();
            const cartaContainerId = `carta-aceptacion-container-${id}`;
            const archivoContainerId = `archivo-container-${id}`;
            const cartaInputId = `carta-aceptacion-${id}`;
            const archivoInputId = `archivo-${id}`;

            select.addEventListener('change', function () {
                updateArchivoVisibility(select.id, cartaContainerId, archivoContainerId, cartaInputId, archivoInputId);
            });

            const modalElement = document.getElementById(`modal${id}`);
            modalElement.addEventListener('show.bs.modal', function () {
                updateArchivoVisibility(select.id, cartaContainerId, archivoContainerId, cartaInputId, archivoInputId);
            });
        });
    });
</script>