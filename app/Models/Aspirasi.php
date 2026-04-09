<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aspirasi extends Model
{
    protected $table = 'aspirasis';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = ['kategori_id','status','feedback','input_pelaporan_id'];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function inputAspirasi()
    {
        return $this->belongsTo(\App\Models\InputAspirasi::class, 'input_pelaporan_id', 'id');
    }
}
