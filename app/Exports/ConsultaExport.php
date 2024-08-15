<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ConsultaExport implements FromCollection, WithMapping, WithHeadings
{
    protected $Artic;

    public function __construct($Artic)
    {
        $this->Artic = $Artic;
    }

    public function collection()
    {
        return collect($this->Artic);
    }

    public function map($row): array
    {
        return [
            $row['id_articulo'],
            $row['revista'],
            $row['titulo'],
            $row['estado'],
            $row['modalidad'],
            $row['descripcion'],
            $row['nombreCompleto'],
            $row['telefono'],
            $row['email'],
        ];
    }

    public function headings(): array
    {
        return [
            'ID Articulo',
            'Revista',
            'Título',
            'Estado',
            'Modalidad',
            'Mesa',
            'Nombre Completo',
            'Teléfono',
            'Email',
        ];
    }
}