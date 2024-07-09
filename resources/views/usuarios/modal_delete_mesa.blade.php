<div class="modal fade" id="modaldelete{{$usuario->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <div class="modal-dialog">
        <form action="{{url("usuarios")}}" method="POST">
        @csrf
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Eliminar revisor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <h3 class="text-danger">¿Estás seguro de eliminar al revisor?</h3>
                    <input type="hidden" name="usuario" value="{{$usuario->id}}">
                    <input type="hidden" name="accion" value="3">
                    <input type="hidden" name="mesa" value="">

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
