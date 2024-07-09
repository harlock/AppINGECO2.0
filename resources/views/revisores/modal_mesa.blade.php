<div class="modal fade" id="modal{{$usuario->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <div class="modal-dialog">
        <form action="{{url("usuarios")}}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Selecciona una mesa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="mesas{{$usuario->id}}" class="form-label">Mesas</label>
                        <input type="hidden" name="usuario" value="{{$usuario->id}}">
                        <input type="hidden" name="accion" value="2">
                        <select name="mesa"  class="form-control" id="mesas{{$usuario->id}}">
                            <option value="" selected="true" disabled="true">Selecciona un valor</option>
                        @foreach($mesas as $mesa)
                                <option value="{{$mesa->id_mesa}}">{{$mesa->descripcion}}</option>
                            @endforeach
                        </select>
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
