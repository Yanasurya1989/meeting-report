<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BidangDuaExport implements FromArray, WithHeadings
{
    protected $data;

    public function __construct(array $rekap)
    {
        $this->data = $rekap;
    }

    public function array(): array
    {
        $result = [];

        foreach ($this->data as $nama => $jumlah) {
            $result[] = [$nama, $jumlah];
        }

        return $result;
    }

    public function headings(): array
    {
        return ['Nama Peserta', 'Jumlah Rapat'];
    }
}
