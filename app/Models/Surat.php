<?php

namespace App\Models;

use App\Models\Kategori;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Surat extends Model {
    use HasFactory;

    protected $fillable = [
        'jenis_surat', 'no_surat', 'pengirim',
        'tanggal_surat', 'tanggal_diterima', 'perihal', 'kategori_id', 'lampiran'
    ];

    public function kategori() {
        return $this->belongsTo(Kategori::class);
    }

    public function agenda() {
        return $this->hasOne(Agenda::class);
    }
}
