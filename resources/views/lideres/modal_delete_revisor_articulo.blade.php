<div class="modal fade" id="modaldelete{{$revisor->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Eliminar revisor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <h3 class="text-danger">¿Estás seguro de eliminar al revisor?</h3>
                    <h3> {{$revisor->nombreRevisores}} </h3>
                    <h3 class="text-danger">del articulo:</h3>
                    <h3 > {{$revisor->titulo}}</h3>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</a>
                <a href="{{route('rev.artic.delete',$revisor->id)}}" class=" btn btn-primary">
                    Eliminar
                </a>
            </div>
        </div>
    </div>
</div>