<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class voucher extends Model
{
    use SoftDeletes;
    protected $table='voucher';
    protected $primaryKey='id_voucher';
    protected $keyType='integer';
    const CREATED_AT='created_at';
    const UPDATED_AT='updated_at';
    const DELETED_AT='deleted_at';
    public $timestamps=true;
    public $incrementing=true;
}
