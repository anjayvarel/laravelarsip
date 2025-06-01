<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    use HasFactory;

    protected $table = 'agenda_acaras'; // Sesuaikan dengan nama tabel di database
    protected $fillable = ['asal', 'hari_tanggal', 'pukul', 'acara', 'tempat', 'surat_id'];

    public function surat()
    {
        return $this->belongsTo(Surat::class, 'surat_id');
    }
    
}
