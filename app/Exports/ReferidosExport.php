<?php

namespace App\Exports;

use App\Models\Referido;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithProperties;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;

class ReferidosExport implements FromCollection,  WithProperties, WithDrawings, ShouldAutoSize, WithEvents, WithCustomStartCell, WithColumnWidths, WithHeadings, WithMapping
{

    public $municipio;
    public $referente_id;
    public $seccion_id;
    public $candidato_id;
    public $status;

    public function __construct($municipio, $referente_id, $seccion_id, $candidato_id, $status)
    {

        $this->municipio = $municipio;
        $this->referente_id = $referente_id;
        $this->seccion_id = $seccion_id;
        $this->candidato_id = $candidato_id;
        $this->status = $status;

    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Referido::with('referente', 'seccion', 'candidato')
                        ->when($this->municipio && $this->municipio != '', function($q){
                            $q->where('municipio', 'like', '%' . $this->municipio . '%');
                        })
                        ->when($this->status, function ($q){
                            $q->where('status', $this->status);
                        })
                        ->when($this->referente_id, function ($q){
                            $q->where('referente_id', $this->referente_id);
                        })
                        ->when($this->seccion_id, function($q){
                            $q->where('seccion_id', $this->seccion_id);
                        })
                        ->when($this->candidato_id, function($q){
                            $q->where('candidato_id', $this->candidato_id);
                        })
                        ->get();
    }

    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('Logo');
        $drawing->setPath(storage_path('app/public/ico.svg'));
        $drawing->setHeight(90);
        $drawing->setOffsetX(10);
        $drawing->setOffsetY(10);
        $drawing->setCoordinates('A1');

        return $drawing;
    }

    public function headings(): array
    {
        return [
            'Referente',
            'Nombre',
            'Status',
            'Sección',
            'Municipio',
            'Teléfono',
            'Calle',
            'Colonia',
            'CP',
            'Clave electoral'
        ];
    }

    public function map($referido): array
    {
        return [
            $referido->referente->nombre,
            $referido->nombre,
            $referido->status,
            $referido->seccion?->seccion,
            $referido->municipio,
            $referido->telefono,
            $referido->domicilio,
            $referido->colonia,
            $referido->cp,
            $referido->clave_electoral
        ];
    }

    public function properties(): array
    {
        return [
            'creator'        => auth()->user()->name,
            'title'          => 'Reporte de Referidos (Elex)',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->mergeCells('A1:J1');
                $event->sheet->setCellValue('A1', "Elex\nReporte de referidos\n" . now()->format('d-m-Y'));
                $event->sheet->getStyle('A1')->getAlignment()->setWrapText(true);
                $event->sheet->getStyle('A1:J1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 13
                    ],
                    'alignment' => [
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
                    ],
                ]);
                $event->sheet->getRowDimension('1')->setRowHeight(90);
                $event->sheet->getStyle('A2:J2')->applyFromArray([
                        'font' => [
                            'bold' => true
                        ]
                    ]
                );
                $event->sheet->getStyle('C:E')->getAlignment()->setWrapText(true);
            },
        ];
    }

    public function startCell(): string
    {
        return 'A2';
    }

    public function columnWidths(): array
    {
        return [
            'E' => 20,
            'F' => 20,

        ];
    }

}
