<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;
    protected $dates =['tanggal_lahir'];
    protected $primaryKey = 'id';
    protected $table = "pegawai";
    protected $fillable = [
        'email',
        'password',
        'nama_pegawai',
        'nik',
        'tanggal_lahir',
        'posisi',
        'unit',
        'divisi_id',
        'jabatan_id'
    ];

    public function divisi()
    {
        return $this->belongsTo(Divisi::class, 'divisi_id');
    }

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'jabatan_id');
    }
}
