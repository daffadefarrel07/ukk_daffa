<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'kategoris';
    protected $fillable = ['ket_kategori'];

    // Backwards-compatible accessor so views/controllers can use ->nama
    public function getNamaAttribute()
    {
        return $this->ket_kategori;
    }

    public function inputAspirasis()
    {
        return $this->hasMany(InputAspirasi::class, 'kategori_id');
    }

    public function aspirasis()
    {
        return $this->hasMany(Aspirasi::class, 'kategori_id');
    }
}
