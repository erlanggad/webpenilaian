<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPenilaian extends Model
{
    use HasFactory;
    // protected $dates =['tanggal_pengajuan','tanggal_lahir'];
    protected $primaryKey = 'id';
    protected $table = "detail_penilaian";
    protected $fillable = [
        'pegawai_id',
        'periode',
        'nilai',
        'criteria_id'
    ];

    // Method untuk mengambil tahun-tahun unik dari kolom 'periode'
    public static function getUniqueYears()
    {
        return DetailPenilaian::selectRaw('periode')
            ->distinct()
            ->pluck('periode')
            ->filter()
            ->toArray();
    }

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }

    public function criteria()
    {
        return $this->belongsTo(Criteria::class, 'criteria_id');
    }
}
