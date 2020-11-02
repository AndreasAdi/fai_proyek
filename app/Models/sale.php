<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class sale extends Model
{
    use softDeletes;

    protected $table='sales';
    protected $primaryKey='id_sales';
    protected $keyType='integer';
    const CREATED_AT='created_at';
    const UPDATED_AT='updated_at';
    const DELETED_AT='deleted_at';
    public $timestamps=true;
    public $incrementing=true;
}
