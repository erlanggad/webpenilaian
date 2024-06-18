<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Events\AfterSheet;

class RankingExport implements WithMultipleSheets
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function sheets(): array
    {
        $sheets = [];

        $sheets[] = new SingleSheetExport($this->data['topsis'], 'Ranking Topsis');
        $sheets[] = new SingleSheetExport($this->data['waspas'], 'Ranking Waspas');
        $sheets[] = new SingleSheetExport($this->data['moora'], 'Ranking Moora');

        return $sheets;
    }
}

class SingleSheetExport implements FromCollection, WithHeadings, WithTitle, WithCustomStartCell, WithEvents
{
    protected $data;
    protected $title;

    public function __construct(array $data, string $title)
    {
        $this->data = $data;
        $this->title = $title;
    }

    public function collection()
    {
        return collect($this->data);
    }

    public function headings(): array
    {
        return ['Nama Lengkap', 'Skor Akhir'];
    }

    public function title(): string
    {
        return $this->title;
    }

    public function startCell(): string
    {
        return 'A2';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->mergeCells('A1:B1');
                $event->sheet->setCellValue('A1', $this->title);
            },
        ];
    }
}
