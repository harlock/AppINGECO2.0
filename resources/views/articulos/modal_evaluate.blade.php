<div class="modal fade" id="modal{{$articu->id_articulo}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <div class="modal-dialog">
        <form action="{{url("evaluar_art",$articu->id_articulo)}}" method="POST">
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
                            <select name="estado" class="form-control">
                                <option value="0" selected="true" disabled="true">Seleccionar estado</option>
                                <option class="" value="1">Aceptar</option>
                                <option class="" value="2">Rechazar</option>
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