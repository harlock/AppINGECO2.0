<div class="modal fade" id="modal{{$articu->id_articulo}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ url('evaluar_art', $articu->id_articulo) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method("PUT")
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">ARTÍCULO</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="text-center text-green-400">
                        <h4 class="text-wrap text-break">{{$articu->titulo}}</h4>
                        <input type="hidden" name="artid" value="{{$articu->id_articulo}}">
                        <p>-----------------------</p>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-7">
                            <h5 class="py-3">Respuesta de la Evaluación</h5>
                        </div>
                        <div class="col-5">
                            <select name="estado" class="form-control" id="estado-select-{{$articu->id_articulo}}">
                                <option value="0" selected="true" disabled="true">Seleccionar estado</option>
                                <option value="1">Aceptar</option>
                                <option value="2">Rechazar</option>
                                <option value="5">Aceptar con condiciones</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3" id="archivo-container-{{$articu->id_articulo}}" style="display: none;">
                        <label for="archivo-{{$articu->id_articulo}}" class="form-label">Subir archivo de evaluación</label>
                        <input type="file" class="form-control" id="archivo-{{$articu->id_articulo}}" name="archivo_evaluacion" accept=".pdf">
                        <p class="mb-3">El tamaño máximo del archivo debe ser de 5MB</p>
                    </div>

                    <div class="mb-3" id="carta-aceptacion-container-{{$articu->id_articulo}}" style="display: none;">
                        <label for="carta-aceptacion-{{$articu->id_articulo}}" class="form-label">Subir carta de aceptación</label>
                        <input type="file" class="form-control" id="carta-aceptacion-{{$articu->id_articulo}}" name="carta_aceptacion" accept=".pdf">
                        <p class="mb-3">El tamaño máximo del archivo debe ser de 5MB</p>
                    </div>

                    <div class="mb-3" id="doc-container-{{$articu->id_articulo}}" style="display: none;">
                        <label for="archivo-doc-{{$articu->id_articulo}}" class="form-label">Subir archivo del artículo</label>
                        <h6 style="color: red">SOLO SE PERMITEN ARCHIVOS .DOC o .DOCX EN ESTA PARTE</h6>
                        <input type="file" class="form-control" id="archivo-doc-{{$articu->id_articulo}}" name="archivo" accept=".doc,.docx">
                        <p class="mb-3">El tamaño máximo del archivo debe ser de 10MB</p>
                    </div>
                </div>
                <script>
                    const estadoSelect = document.getElementById('estado-select-{{$articu->id_articulo}}');
                    const archivoContainer = document.getElementById('archivo-container-{{$articu->id_articulo}}');
                    const cartaAceptacionContainer = document.getElementById('carta-aceptacion-container-{{$articu->id_articulo}}');
                    const docContainer = document.getElementById('doc-container-{{$articu->id_articulo}}');

                    const archivoInput = document.getElementById('archivo-{{$articu->id_articulo}}');
                    const cartaAceptacionInput = document.getElementById('carta-aceptacion-{{$articu->id_articulo}}');
                    const docInput = document.getElementById('archivo-doc-{{$articu->id_articulo}}');

                    // Evento para mostrar los campos según la selección
                    estadoSelect.addEventListener('change', function() {
                        archivoContainer.style.display = 'none';
                        cartaAceptacionContainer.style.display = 'none';
                        docContainer.style.display = 'none';

                        archivoInput.required = false;
                        cartaAceptacionInput.required = false;
                        docInput.required = false;

                        if (estadoSelect.value == '1')
                        {  // Aceptar
                            cartaAceptacionContainer.style.display = 'block';
                            cartaAceptacionInput.required = true;
                        }
                        else if (estadoSelect.value == '2')
                        {  // Rechazar
                            archivoContainer.style.display = 'block';
                            archivoInput.required = true;
                        }
                        else if (estadoSelect.value == '5')
                        {  // Aceptar con condiciones
                            docContainer.style.display = 'block';
                            docInput.required = true;
                        }
                    });
                </script>

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
        function updateArchivoVisibility(selectElementId, cartaContainerId, archivoContainerId, docContainerId)
        {
            const selectElement = document.getElementById(selectElementId);
            const cartaContainer = document.getElementById(cartaContainerId);
            const archivoContainer = document.getElementById(archivoContainerId);
            const docContainer = document.getElementById(docContainerId);

            // Ocultar todos los contenedores inicialmente
            cartaContainer.style.display = 'none';
            archivoContainer.style.display = 'none';
            docContainer.style.display = 'none';

            if (selectElement.value == '1')
            {
                cartaContainer.style.display = 'block';
            }
            else if (selectElement.value == '5')
            {
                docContainer.style.display = 'block';
            }
            else if (selectElement.value == '2')
            {
                archivoContainer.style.display = 'block';
            }
        }

        document.querySelectorAll('[id^=estado-select-]').forEach(select =>
        {
            const id = select.id.split('-').pop();
            const cartaContainerId = `carta-aceptacion-container-${id}`;
            const archivoContainerId = `archivo-container-${id}`;
            const docContainerId = `doc-container-${id}`;

            select.addEventListener('change', function () {
                updateArchivoVisibility(select.id, cartaContainerId, archivoContainerId, docContainerId);
            });

            const modalElement = document.getElementById(`modal${id}`);
            modalElement.addEventListener('show.bs.modal', function () {
                updateArchivoVisibility(select.id, cartaContainerId, archivoContainerId, docContainerId);
            });
        });
    });
</script>
