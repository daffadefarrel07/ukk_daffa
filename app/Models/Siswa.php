<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $table = 'siswas';
    protected $fillable = ['nis','kelas','user_id'];

    public function inputAspirasis()
    {
        return $this->hasMany(InputAspirasi::class, 'siswa_id');
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
