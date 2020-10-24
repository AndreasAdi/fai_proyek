<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class statusorder extends Model
{
    protected $table='statusorder';
    protected $primaryKey='id_status';
    protected $keyType='integer';
    public $timestamps=true;
    const CREATED_AT='created_at';
    const UPDATED_AT='updated_at';
    public $incrementing=true;
}
