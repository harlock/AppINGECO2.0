<div class="modal fade" id="modaldeleteRevisor{{$usuario->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{route ("registro.revisor",$usuario->id)}}" method="POST">
            @csrf
            @method("PUT")
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Eliminar Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3 text-center">
                        <h3 class="text-danger">¿Estás seguro de eliminar al revisor <br>{{$usuario->name}} {{$usuario->ap_paterno}} {{$usuario->ap_materno}}?</h3>
                        <input type="hidden" name="idd" value="{{$usuario->id}}">
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
