<div class="modal fade" id="modal{{$usuario->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <div class="modal-dialog">
        <form action="{{url('lideres')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Asignación de autor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <div class="p-4">
                            <h3 >Asignar al revisor:</h3>
                            
                            <h5 class="p-2">{{$usuario->name}} {{$usuario->ap_paterno}} {{$usuario->ap_materno}}</h5>
                        </div>
                        <div class="p-4">
                            <h3 >Al artículo:</h3>
                            <input type="hidden" name="id" value="{{$usuario->id}}">
                            <select name="id_articulo" class="form-control" id="articulo{{$usuario->id}}">
                                <option value="" selected="true" disabled="true">Selecciona un artículo</option>
                                @foreach($articulos as $articulo)
                                <option value="{{$articulo->id_articulo}}">{{$articulo->titulo}}--{{$articulo->revista}}</option>
                                @endforeach
                            </select>
                        </div>
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