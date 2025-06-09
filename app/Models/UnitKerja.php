<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitKerja extends Model
{
    use HasFactory;

    protected $table = 'tb_unit_kerja';
    protected $primaryKey = 'id_unit_kerja';

    protected $fillable = [
        'nama_unit_kerja',
    ];
}
