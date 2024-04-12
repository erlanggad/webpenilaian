<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Konfig_cuti extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_konfig_cuti';
    protected $table = "konfig_cuti";
    protected $fillable = [
        'tahun',
        'cuti_bersama',
        'jumlah_cuti',
    ];
}
