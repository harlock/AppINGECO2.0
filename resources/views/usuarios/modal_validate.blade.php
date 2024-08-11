<div class="modal fade" id="modal{{$user->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{url("usuarios",$user->id)}}" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Estado de Aprobación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <h3>Asignar a:</h3>
                        <div class="p-4">

                        <input type="hidden" name="usuar" value="{{$user->id}}">
                        <h2>{{$user->name}} {{$user->ap_paterno}} {{$user->ap_materno}}</h2>
                        <select name="user_type"  class="form-select" id="usuarios{{$user->id}}">
                            <option value="" selected="true" disabled="true">Asignar como...</option>
                                <option value="4">Líder</option>
                                <option value="2">Revisor</option>
                                <option value="5">Contador</option>
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

