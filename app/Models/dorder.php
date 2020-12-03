<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class dorder extends Model
{
    protected $table='dorder';
    protected $primaryKey='id_dorder';
    protected $keyType='integer';
    public $timestamps=true;
    const CREATED_AT='created_at';
    const UPDATED_AT='updated_at';
    const DELETED_AT='deleted_at';
    public $incrementing=true;

    function horder() {
        return $this->belongsTo('App\Models\horder','id_dorder');
    }
    function barang() {
        return $this->belongsTo('App\Models\barang','id_barang');
    }
}
