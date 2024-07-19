@extends('layouts.app')
@section('content')
<div class="container py-5">

    <div class="row  w-full p-5">
        <div class="d-flex  row">
            <div class="pe-3">
                <a class="btn btn-primary " href="/"><i class="bi bi-box-arrow-left"></i> Inicio</a>

            </div>
            <div class="col-10">
                <h3 class=" justify-content-center alert alert-success d-flex  ">
                    <p> Registro de artículos</p>

                </h3>
            </div>
            <div class="col-10">
                <h3 class=" justify-content-center alert alert-danger d-flex  ">
                    <p><span>EL periodo para registro de artículos ha terminado.</span></p>
                    

                </h3>
            </div>

        </div>
    </div>
    <!--<form>-->
    
    <form action="{{url('enviar_articulo')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row row-cols-1 row-cols-sm-1 row-cols-md-1 justify-content-center ">
           
            
            <div class="">
                <div class="row justify-content-center">
                    <div class="col-8 justify-content-center shadow p-3 mb-5 bg-body rounded alert alert-success">
                        <p class="text-center ">
                            Datos del autor de correspondencia
                        </p>
                    </div>
                </div>
                <div class="row row-cols-1 row-cols-sm-1 row-cols-md-1  row-cols-lg-1 row-cols-xl-1 row-cols-xxl-2 justify-content-center">

                    <div class="mb-3 col">
                        <div class=" bd-highlight mb-3">
                            <label for="exampleInputEmail1" class="form-label"><h4>Nombre </h4></label>
                            <div class="col-10">@error('nom_autor') <span class="alert alert-danger p-2">{{ $message }}</span>@enderror</div>
                        </div>
                        <input type="text" id="nombre" name="nom_autor" class="form-control" placeholder="Escriba el nombre del autor" value="{{old("nom_autor")}}">
                        <div id="emailHelp" class="form-text">Nombre del autor</div>
                    </div>

                    <div class="mb-3 col">
                        <div class="d-flex flex-column bd-highlight mb-3">
                            <label for="exampleInputEmail1" class="form-label"><h4>Apellido paterno </h4></label>
                            <div class="col-10">@error('ap_autor') <span class="alert alert-danger p-2">{{ $message }}</span>@enderror</div>
                        </div>
                        <input type="text" id="apellio_p" name="ap_autor" class="form-control" placeholder="Escriba el apellido paterno del autor" value="{{old("ap_autor")}}">
                        <div id="emailHelp" class="form-text">Apellido paterno del autor</div>
                    </div>
                    <div class="mb-3 col">
                        <div class="d-flex flex-column bd-highlight mb-3">
                            <label for="exampleInputEmail1" class="form-label"><h4>Apellido materno </h4></label>
                            <div class="col-10">@error('am_autor') <span class="alert alert-danger p-2">{{ $message }}</span>@enderror</div>
                        </div>
                        <input type="text" id="apellio_m" name="am_autor" class="form-control" placeholder="Escriba el apellido materno del autor" value="{{old("am_autor")}}">
                        <div id="emailHelp" class="form-text">Apellido materno del Autor</div>
                    </div>



                    <div class="mb-3 col">
                        <div class="d-flex flex-column bd-highlight mb-3">
                            <label for="exampleInputEmail1" class="form-label"><h4>Correo</h4></label>
                            <div class="col-10">@error('correo') <span class="alert alert-danger p-2">{{ $message }}</span>@enderror</div>
                        </div>
                        <input type="text" id="correo" name="correo" class="form-control" placeholder="Escriba su correo del autor" value="{{old("correo")}}">
                        <div id="emailHelp" class="form-text">Correo del autor</div>
                    </div>
                    <div class="mb-3 col">
                        <div class="d-flex flex-column bd-highlight mb-3">
                            <label for="exampleInputEmail1" class="form-label"><h4>Teléfono</h4></label>
                            <div class="col-10">@error('tel') <span class="alert alert-danger p-2">{{ $message }}</span>@enderror</div>
                        </div>
                        <input type="text" name="tel" class="form-control" placeholder="Ingrese el telefono" value="{{old("tel")}}">
                        <div id="emailHelp" class="form-text">Teléfono del autor</div>
                    </div>

                </div>
            </div>

           
            <div class="">
                <div class="row justify-content-center">
                    <div class="col-8 justify-content-center shadow p-3 mb-5 bg-body rounded alert alert-success">
                        <p class="text-center">
                            Datos del artículo
                        </p>
                    </div>
                </div>
                <div class="row row-cols-1 row-cols-sm-1 row-cols-md-1 row-cols-lg-3 justify-content-center">
                    <!-- SELECCIONAR REVISTA  -->
                    <div class="mb-3 col">
                        <div class="d-flex flex-column bd-highlight mb-3">
                            <label for="exampleInputEmail1" class="form-label">
                                <h4>Revista*</h4>
                            </label>
                            <div class="col-10">
                                @error('revista') <span class="alert alert-danger p-2">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <select name="revista" class="form-select" id="revista">
                            <option value="" selected="true" disabled="true">Selecciona una revista</option>
                            <option value="FEGLININ" {{ old('revista') == 'FEGLININ' ? 'selected' : '' }}>FEGLININ</option>
                            <option value="RECIE" {{ old('revista') == 'RECIE' ? 'selected' : '' }}>RECIE</option>
                        </select>
                        <div id="emailHelp" class="form-text">Seleccionar la revista de publicación. </div>
                    </div>
                    <!-- INSERTAR TITULO ARTICULO  -->
                    <div class="mb-3 col">
                        <div class="d-flex flex-column bd-highlight mb-3">
                            <label for="exampleInputEmail1" class="form-label">
                                <h4>Título del artículo*</h4>
                            </label>
                            <div class="col-10">
                                @error('titulo') <span class="alert alert-danger p-2">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <textarea type="text" name="titulo" class="form-control" placeholder="Escriba el título del artículo" id="titulo">{{old("titulo")}}</textarea>
                        <div id="emailHelp" class="form-text">Inserte título del artículo.</div>
                    </div>
                    <!-- INSERTAR ARCHIVO  -->
                    <div class="mb-3 col">
                        <div class="d-flex flex-column bd-highlight mb-3">
                            <label for="exampleInputEmail1" class="form-label">
                                <h4>Archivo*</h4>
                            </label>
                            <div class="col-10">
                                @error('archivo') <span class="alert alert-danger p-2">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <input id="archivoNombre" type="file" name="archivo" class="form-control" placeholder="Inserte el archivo word" value="{{old("archivo")}}" accept=".doc,.docx">
                        <div id="emailHelp" class="form-text">Selecciona artículo en formato word.</div>
                    </div>
                    <!-- SELECCIONAR MESA DE TRABAJO  -->
                    <div class="mb-3 col">
                        <div class="d-flex flex-column bd-highlight mb-3">
                            <label for="exampleInputEmail1" class="form-label">
                                <h4>Área</h4>
                            </label>
                            <div class="col-10">
                                @error('id_mesa') <span class="alert alert-danger p-2">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <select name="id_mesa" class="form-select" id="id_mesa">
                            <option value="" selected="true" disabled="true">Selecciona una mesa</option>
                            @foreach($mesas as $mesa)
                                <option value="{{$mesa->id_mesa}}" data-description="{{$mesa->descripcion}}"
                                        {{ old('id_mesa') == $mesa->id_mesa ? 'selected' : '' }}>
                                    {{$mesa->descripcion}}
                                </option>
                            @endforeach
                        </select>

                        <div id="emailHelp" class="form-text">Seleccionar mesa. </div>
                    </div>
                    <!-- SELECCIONAR MODALIDAD  -->
                    <div class="mb-3 col">
                        <div class="d-flex flex-column bd-highlight mb-3">
                            <label for="exampleInputEmail1" class="form-label">
                                <h4>Modalidad*</h4>
                            </label>
                            <div class="col-10">
                                @error('modalidad') <span class="alert alert-danger p-2">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <select name="modalidad" class="form-select" id="modalidad">
                            <option value="" selected="true" disabled="true">Selecciona una modalidad</option>
                            <option value="Virtual" {{ old('modalidad') == 'Virtual' ? 'selected' : '' }}>Virtual</option>
                            <option value="Presencial" {{ old('modalidad') == 'Presencial' ? 'selected' : '' }}>Presencial</option>
                        </select>
                        <div id="emailHelp" class="form-text">Seleccionar modalidad en caso de aceptación del artículo. </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- boton de enviar -->
        <div class="d-flex  justify-content-center py-4">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" onclick="getDatos()" data-bs-target="#exampleModal">Guardar</button>
        </div>

        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <h3 class="modal-title" id="exampleModalLabel">
                            ¿Estas seguro de que deseas enviar el artículo?
                        </h3>
                    </div>

                    <div class=" p-4 ">
                        <div class="d-flex">
                            <div class="px-2">Correo de correspondencia:</div>
                            <div class="px-2" id="showCorreo"></div>
                        </div>
                        <div class="d-flex">
                            <span class="px-2" style="color: red; font-size: small;">Se notificara el estado del artículo a este correo.</span>
                        </div>
                        <div class="d-flex">
                            <div class="px-2">Nombre:</div>
                            <div class="px-2" id="showNombre"></div>
                        </div>
                        <div class="d-flex">
                            <div class="px-2">Apellido Paterno:</div>
                            <div class="px-2" id="showApellidoP"></div>
                        </div>
                        <div class="d-flex">
                            <div class="px-2">Apellido Materno:</div>
                            <div class="px-2" id="showApellidoM"></div>
                        </div>
                        <table>
                            <div class="d-flex">
                                <div class="px-2">Revista:</div>
                                <div class="px-1" id="showRevista"></div>
                            </div>

                            <div class="d-flex">
                                <div class="px-2">Titulo:</div>
                                <div class="px-1" id="showTitulo"></div>
                            </div>

                            <div class="d-flex">
                                <div class="px-2">Mesa:</div>
                                <div class="px-1" id="showMesa"></div>
                            </div>

                            <div class="d-flex">
                                <div class="px-2">Modalidad:</div>
                                <div class="px-1" id="showModalidad"></div>
                            </div>

                        </table>
                        <div class="d-flex justify-content-center mt-3">
                            <button type="button" class="btn btn-info" id="verArchivoBtn">Ver archivo</button>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Aceptar</button>
                    </div>
                </div>
            </div>
        </div>
        <br>
        @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
        @endif
        <br>

        <div class="">
            @if($articulos)
            <div class="col ">
                <h3 class=" justify-content-center alert bg-blue-800 d-flex  text-white">
                    Artículos enviados
                </h3>
            </div>
            <br>

            <div class=" table-responsive-xl bg-white border rounded-lg mt-4 p-3 shadow-sm tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                <table class="table ">
                    <thead class="">
                        <tr class="bg-white">
                            <th class=" text-center">Estado</th>
                            <th class=" text-center">Revista</th>
                            <th class=" text-center">Nombre del artículo</th>
                            <th class=" text-center">Modalidad</th>
                            <th class=" text-center">Archivo</th>
                            <th class=" text-center">Mesa asignada</th>
                        </tr>
                    </thead>
                    <tbody class="">
                        @foreach ($articulos as $articulo)
                        <tr class=" {{ $articulo->estado == 0 ? "bg-gray-100" : ($articulo->estado == 1 ? "bg-green-100" : ($articulo->estado == 2 ? "bg-red-100" : "bg-yellow-100")) }}">
                            <td class="">
                                @if($articulo->estado == 0)
                                <i class="bi bi-bookmark-dash-fill"></i> Sin revisar
                                @elseif($articulo->estado == 1)
                                <i class="bi bi-bookmark-check-fill"></i> Aceptado
                                @elseif($articulo->estado == 2)
                                <i class="bi bi-bookmark-x-fill"></i> Rechazado
                                @else
                                <i class="bi bi-bookmark-dash-fill"> </i> En proceso de revisión
                                @endif
                            </td>
                            <td>{{$articulo->revista }}</td>
                            <td class="text-wrap text-break">{{$articulo->titulo }}</td>
                            <td>{{$articulo->modalidad }}</td>
                            <td class="font-semibold ">
                                <a class="btn btn-primary" href="{{route('art.download',$articulo->titulo)}}">Descargar <i class="bi bi-arrow-down-square-fill"></i></a>
                            </td>
                            <td class="text-wrap text-break">{{$articulo->descripcion }}</td>
                            <td>
                               
                                <a href="{{route('art.destroy',$articulo->id_articulo)}}" class=" btn btn-danger">
                                    Eliminar
                                </a>
                             
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>

    </form>

    

</div>


<footer>
    <section class=" border ">
        <div class="container">
            <div class="row justify-content-center  ">
                <div class="py-2   d-flex ">
                    <div class="px-2">
                        <h5>Nota: </h5>
                    </div>
                    <small>
                        Recuerda que estaremos enviando por correo tus resultados, en caso de ser aprobado tendrás que realizar el pago y la presentación para poder recibir la constancia.
                    </small>

                </div>
            </div>
        </div>
    </section>
    <section class="copyright border">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-12 pt-3">
                    <p class="text-muted">© INGECO </p>
                </div>
            </div>
        </div>
    </section>
</footer>

@push("scripts")
    <script type="text/javascript">
        // Obtener los elementos del DOM
        var selectElement = document.getElementById("id_mesa");
        var showMesaElement = document.getElementById("showMesa");

        // Función para mostrar los datos en el HTML
        function getDatos() {
            // Obtener y mostrar el título
            var showTitulo = document.getElementById("showTitulo");
            showTitulo.innerHTML = document.getElementById("titulo").value;

            // Obtener y mostrar los datos del usuario
            var nombre = document.getElementById("nombre").value;
            var apellidoP = document.getElementById("apellio_p").value;
            var apellidoM = document.getElementById("apellio_m").value;
            var correo = document.getElementById("correo").value;

            document.getElementById("showNombre").innerText = nombre;
            document.getElementById("showApellidoP").innerText = apellidoP;
            document.getElementById("showApellidoM").innerText = apellidoM;
            document.getElementById("showCorreo").innerText = correo;

            // Obtener y mostrar la modalidad
            var showRevista = document.getElementById("showRevista");
            showRevista.innerHTML = document.getElementById("revista").value;

            var showModalidad = document.getElementById("showModalidad");
            showModalidad.innerHTML = document.getElementById("modalidad").value;

            // Mostrar la descripción de la mesa (opcional)
            // var showMesa = document.getElementById("showMesa");
            // showMesa.innerHTML = document.getElementById("id_mesa").textContent;
        }

        // Evento para actualizar la descripción de la mesa al cambiar la selección
        selectElement.addEventListener("change", function() {
            var selectedOption = selectElement.options[selectElement.selectedIndex];
            var descripcion = selectedOption.getAttribute("data-description");
            showMesaElement.textContent = descripcion;
        });

        // Evento para manejar la descarga del archivo
        document.getElementById('verArchivoBtn').addEventListener('click', function() {
            var fileInput = document.getElementById('archivoNombre');
            if (fileInput.files.length > 0) {
                var file = fileInput.files[0];
                var url = URL.createObjectURL(file);
                var a = document.createElement('a');
                a.href = url;
                a.download = file.name;
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
                URL.revokeObjectURL(url);
            } else {
                alert('No se ha seleccionado ningún archivo.');
            }
        });
    </script>

@endpush
@endsection
