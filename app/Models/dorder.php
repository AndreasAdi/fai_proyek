<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class dorder extends Model
{
    protected $table='dorder';
    protected $primaryKey='id_dorder';
    protected $keyType='integer';
    public $timestamps=false;
    public $incrementing=true;
}
