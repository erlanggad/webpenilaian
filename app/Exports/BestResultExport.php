<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BestResultExport implements FromArray, WithHeadings
{
    protected $bestResult;

    public function __construct(array $bestResult)
    {
        $this->bestResult = $bestResult;
    }

    public function array(): array
    {
        return [
            [
                $this->bestResult['nama'],
                $this->bestResult['metode'],
                $this->bestResult['skor']
            ]
        ];
    }

    public function headings(): array
    {
        return ["Nama", "Metode", "Skor"];
    }
}
