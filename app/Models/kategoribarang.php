<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class kategoribarang extends Model
{
    protected $table='kategoribarang';
    protected $primaryKey='id_kategori';
    protected $keyType='integer';
    public $timestamps=false;
    public $incrementing=true;
}
