<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengajuan_cuti extends Model
{
    use HasFactory;
    protected $dates =['tanggal_pengajuan','tanggal_lahir'];
    protected $primaryKey = 'id_pengajuan_cuti';
    protected $table = "pengajuan_cuti";
    protected $fillable = [
        'pegawai_id',
        'tanggal_pengajuan',
        'lama_cuti',
        'keterangan',
        'alamat',
        'divisi',
        'ttd_karyawan',
        'status',
        'verifikasi_oleh',
        'jabatan_verifikasi',
        'catatan'

    ];
}
