<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class notifikasi extends Model
{
    protected $table='notifikasi';
    protected $primaryKey='id_notifikasi';
    protected $keyType='integer';
    public $timestamps=false;
    public $incrementing=true;
}
