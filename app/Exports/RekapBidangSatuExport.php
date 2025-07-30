<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RekapBidangSatuExport implements FromCollection, WithHeadings
{
    protected $rekap;

    public function __construct($rekap)
    {
        $this->rekap = $rekap;
    }

    public function collection()
    {
        $data = [];

        foreach ($this->rekap as $nama => $jumlah) {
            $data[] = [
                'nama_peserta' => $nama,
                'jumlah_rapat' => $jumlah
            ];
        }

        return collect($data);
    }

    public function headings(): array
    {
        return ['Nama Peserta', 'Jumlah Rapat'];
    }
}
