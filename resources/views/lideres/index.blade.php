@extends('layouts.app')

@section('content')

    <div class="row mx-20">
        <div class="col bg-blue-800 rounded-lg justify-content-center">
            <h3 class="justify-content-center alert d-flex text-white">
                Asignación de revisores
            </h3>
        </div>
    </div>

    <div class="row justify-content-center mt-4">
        <div class="col-10">
            <div class="card">
                <div class="row">
                    <div class="col-6">
                        <div class="card-body">
                            <h5 class="card-title alert alert-primary">Lista de revisores</h5>
                            <ul class="list-group">
                                @foreach($usuarios as $usuario)
                                    <li class="list-group-item">
                                        {{$usuario->name}} {{$usuario->ap_paterno}} {{$usuario->ap_materno}}
                                        <button type="button" class="btn btn-outline-info float-end" data-bs-toggle="modal" data-bs-target="#modal{{$usuario->id}}">
                                            <i class="bi bi-plus-square-fill"></i> Asignar artículo
                                        </button>
                                        @include("lideres.modal_asigna_autor")
                                        @include("lideres.modal_delete_revisor")
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card-body">
                            <h5 class="card-title alert alert-primary">Revisores asignados</h5>
                            <div class="mb-3">
                                <input type="text" class="form-control" id="searchAssigned" placeholder="Buscar revisor o artículo...">
                            </div>
                            <ul class="list-group" id="assignedList">
                                @foreach($lista_revisores->groupBy('nombreRevisores') as $nombreRevisor => $articulos)
                                    <li class="list-group-item revisor-item">
                                        <h4>
                                            <span style="color: #313278; font-size: 1.3rem;">Revisor: </span>
                                            <span class="revisor-name" style="color: #5356dd; font-size: 1.3rem;">{{ $nombreRevisor }}</span>
                                        </h4>
                                        <ul class="list-group mt-2">
                                            @foreach($articulos as $revisor)
                                                <li class="list-group-item" style="background: #f6f6f6">
                                                    <div class="articulo-titulo">{{ $revisor->titulo }}</div>
                                                    @php
                                                        $estado = $revisor->estado;
                                                        $disableButton = !in_array($estado, [0, 4]); // Deshabilita si el estado no es 0 o 4
                                                    @endphp
                                                    <button type="button" class="btn btn-outline-danger mt-2"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#modaldelete{{$revisor->id}}"
                                                            @if($disableButton) disabled @endif>
                                                        <i class="bi bi-trash-fill"></i> Eliminar del artículo
                                                    </button>
                                                </li>

                                                @include("lideres.modal_delete_revisor_articulo", ['revisor' => $revisor])
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
                const listItems = Array.from(assignedList.querySelectorAll('.revisor-item'));

                searchInput.addEventListener('keyup', function () {
                    const filter = this.value;
                    let matchedItems = [];
                    let otherItems = [];

                    listItems.forEach(function (item) {
                        let revisorName = item.querySelector('.revisor-name').textContent;
                        let articuloTitulos = item.querySelectorAll('.articulo-titulo');
                        let regex = new RegExp(filter, 'gi');
                        let matched = false;

                        if (revisorName.match(regex)) {
                            matched = true;
                            item.querySelector('.revisor-name').innerHTML = revisorName.replace(regex, function (matchedText) {
                                return `<span class="highlight">${matchedText}</span>`;
                            });
                        } else {
                            item.querySelector('.revisor-name').innerHTML = revisorName;
                        }

                        articuloTitulos.forEach(function (titleElem) {
                            let articuloTitulo = titleElem.textContent;
                            if (articuloTitulo.match(regex)) {
                                matched = true;
                                titleElem.innerHTML = articuloTitulo.replace(regex, function (matchedText) {
                                    return `<span class="highlight">${matchedText}</span>`;
                                });
                            } else {
                                titleElem.innerHTML = articuloTitulo;
                            }
                        });

                        if (matched) {
                            matchedItems.push(item);
                        } else {
                            otherItems.push(item);
                        }
                    });

                    assignedList.innerHTML = '';
                    matchedItems.concat(otherItems).forEach(function (item) {
                        assignedList.appendChild(item);
                    });

                    if (filter === '') {
                        assignedList.innerHTML = '';
                        listItems.forEach(function (item) {
                            assignedList.appendChild(item);
                        });
                    }
                });
            });
        </script>

        <style>
            .highlight {
                background-color: yellow;
            }
        </style>
    @endpush
@endsection
