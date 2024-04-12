<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Urgensi_Cuti extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $table = "urgensi_cuti";
    protected $fillable = [
       'id',
       'nama',
       'nilai',
       'lama_cuti'
    ];
}
