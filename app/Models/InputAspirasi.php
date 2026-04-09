<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InputAspirasi extends Model
{
    protected $table = 'input_aspirasis';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';
protected $fillable = ['siswa_id','kategori_id','lokasi','ket','foto'];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function aspirasi()
    {
        return $this->hasOne(\App\Models\Aspirasi::class, 'input_pelaporan_id', 'id_pelaporan');
    }
}
