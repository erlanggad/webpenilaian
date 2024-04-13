<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    use HasFactory;
    // protected $dates =['tanggal_pengajuan','tanggal_lahir'];
    protected $primaryKey = 'id';
    protected $table = "penilaian";
    protected $fillable = [
        'pegawai_id',
        'c1',
        'c2',
        'c3',
        'c4',
        'c5',
        'c6',
        'c7',
        'c8',
    ];
}
