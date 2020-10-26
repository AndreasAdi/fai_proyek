<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class kodeverifikasi extends Model
{
    protected $table='kodeverifikasi';
    protected $primaryKey='id';
    protected $keyType='integer';
    public $timestamps=false;
    public $incrementing=true;
}
