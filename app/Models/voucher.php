<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class voucher extends Model
{
    protected $table='voucher';
    protected $primaryKey='id_voucher';
    protected $keyType='integer';
    public $timestamps=false;
    public $incrementing=true;
}
