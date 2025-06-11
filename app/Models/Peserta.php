<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Peserta extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_peserta';
    protected $primaryKey = 'id_peserta';

    protected $fillable = [
        'id_users',
        'id_unit_kerja',
        'id_mentor',
        'nama_peserta',
        'jabatan_peserta',
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
        return $this->belongsTo(UnitKerja::class, 'id_unit_kerja', 'id_unit_kerja');
    }

    // Relasi dengan model Mentor
    public function Mentor()
    {
        return $this->belongsTo(Mentor::class, 'id_mentor');
    }
}