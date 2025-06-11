<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kegiatan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_kegiatan';
    protected $primaryKey = 'id_kegiatan';

    protected $fillable = [
        'id_peserta',
        'tanggal_mulai_kegiatan',
        'tanggal_selesai_kegiatan',
        'deskripsi_kegiatan',
        'progres_kegiatan',
        'keterangan_kegiatan',
        'status_kegiatan',
        'catatan_pembimbing',

    ];

    protected $dates = ['deleted_at'];


    // Relasi dengan model peserta
    public function Peserta()
    {
        return $this->belongsTo(Peserta::class, 'id_peserta', 'id_peserta');
    }
}