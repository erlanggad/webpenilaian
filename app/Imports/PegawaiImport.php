<?php

namespace App\Imports;

use App\Models\Pegawai;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Hash;

class PegawaiImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            Pegawai::create([
                'email' => $row['email'],
                'password' => $row['password'],
                'nama_pegawai' => $row['nama_pegawai'],
                'nik' => $row['nik'],
                'tanggal_lahir' => $row['tanggal_lahir'],
                'jabatan_id' => $row['jabatan_id'],
                'divisi_id' => $row['divisi_id'],
            ]);
        }
    }
}
