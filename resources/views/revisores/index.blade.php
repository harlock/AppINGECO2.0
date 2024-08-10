@extends('layouts.app')

@section('content')
    <div class="row mx-20">
        <div class="col bg-blue-800 rounded-lg">
            <h3 class=" justify-content-center alert  d-flex text-white ">
                Asignación de revisores a mesas
            </h3>
        </div>
    </div>

    <div class="row justify-content-center mt-4">
        <div class="col-10">
            <div class="card">
                <div class="row">
                    <div class="col-6">
                        <div class="card-body">
                            <h5 class="card-title alert alert-primary">Revisores sin asignar</h5>
                            <ul class="list-group">
                                @foreach($usuariosRegistrados as $usuario)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <span>{{$usuario->name}} {{$usuario->ap_paterno}} {{$usuario->ap_materno}}</span>
                                        </div>
                                        <div>
                                            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                                    data-bs-target="#modaldeleteRevisor{{$usuario->id}}">
                                                <i class="bi bi-trash-fill"></i>Eliminar de los revisores
                                            </button>
                                            <button type="button" class="btn btn-outline-info" data-bs-toggle="modal"
                                                    data-bs-target="#modal{{$usuario->id}}">
                                                <i class="bi bi-plus-square-fill"></i>
                                            </button>

                                        </div>
                                    </li>
                                    @include("revisores.modal_mesa")
                                    @include("revisores.modal_delete_revisor")
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card-body">
                            <h5 class="card-title alert alert-primary">Revisores asignados</h5>
                            <div class="mb-3">
                                <input type="text" class="form-control" id="searchAssigned"
                                       placeholder="Buscar revisor o mesa...">
                            </div>
                            <ul class="list-group" id="assignedList">
                                @foreach($usuariosAsignados->groupBy('descripcion') as $mesa => $usuarios)
                                    <li class="list-group-item">
                                        <h4 class="mb-2" style="color: #313278; font-size: 1.3rem;">{{ $mesa }}</h4>
                                        <ul class="list-group mt-2">
                                            @foreach($usuarios as $usuario)
                                                <li class="list-group-item d-flex justify-content-between align-items-center"
                                                    style="background: #f6f6f6">
                                                    <div class="usuario-info">{{ $usuario->name }} {{$usuario->ap_paterno}} {{$usuario->ap_materno}}</div>
                                                    <button type="button" class="btn btn-outline-danger"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#modaldelete{{$usuario->id}}">
                                                        <i class="bi bi-trash-fill"></i> Eliminar
                                                    </button>
                                                </li>
                                                @include("revisores.modal_delete_mesa", ['usuario' => $usuario])
                                            @endforeach
                                        </ul>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push("scripts")
        <script type="text/javascript">
            document.addEventListener('DOMContentLoaded', function () {
                const searchInput = document.getElementById('searchAssigned');
                const assignedList = document.getElementById('assignedList');

                searchInput.addEventListener('input', function () {
                    const filter = searchInput.value.toLowerCase();
                    const listItems = assignedList.getElementsByTagName('li');

                    Array.from(listItems).forEach(item => {
                        const text = item.textContent || item.innerText;
                        const isVisible = text.toLowerCase().includes(filter);

                        // Highlight matched text
                        item.innerHTML = highlightText(text, filter);
                        item.style.display = isVisible ? '' : 'none';
                    });
                });

                function highlightText(text, filter) {
                    if (!filter.trim()) return text;
                    const regex = new RegExp(`(${filter})`, 'gi');
                    return text.replace(regex, match => `<span class="highlight">${match}</span>`);
                }
            });
        </script>


        <style>
            .highlight {
                background-color: yellow;
            }
        </style>
    @endpush
@endsection
