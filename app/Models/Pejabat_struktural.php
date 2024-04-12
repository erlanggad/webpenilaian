<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pejabat_struktural extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_pejabat_struktural';
    protected $table = "pejabat_struktural";
    protected $fillable = [
        'nama_pejabat_struktural',
        'jabatan',
        'divisi',
        'email',
        'password',
        'image'=> 'image|file',
    ];
    public $timestamps = false;

}
