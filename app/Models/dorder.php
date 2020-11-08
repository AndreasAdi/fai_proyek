<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class dorder extends Model
{
    protected $table='dorder';
    protected $primaryKey='id_dorder';
    protected $keyType='integer';
    public $timestamps=false;
    public $incrementing=true;

    function horder() {
        return $this->belongsTo('App\Models\horder','id_dorder');
    }
    function barang() {
        return $this->belongsTo('App\Models\barang','id_barang');
    }
}
