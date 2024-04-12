<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $table = "jabatan";
    // protected $fillable = [
    //     'ket_divisi',
    // ];
}
