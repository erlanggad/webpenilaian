<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Divisi extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $table = "divisi";
    // protected $fillable = [
    //     'ket_divisi',
    // ];
}
