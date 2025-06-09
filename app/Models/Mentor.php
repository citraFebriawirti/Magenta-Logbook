<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mentor extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_mentor';
    protected $primaryKey = 'id_mentor';

    protected $fillable = [
        'id_users',
        'id_unit_kerja',
        'nama_mentor',
        'jabatan_mentor',
    ];

    protected $dates = ['deleted_at'];

    // Relasi dengan model User
    public function user()
    {
        return $this->belongsTo(User::class, 'id_users');
    }

    // Relasi dengan model UnitKerja
    public function unitKerja()
    {
        return $this->belongsTo(UnitKerja::class, 'id_unit_kerja');
    }
}
