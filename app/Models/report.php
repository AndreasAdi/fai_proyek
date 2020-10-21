<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class report extends Model
{
    use SoftDeletes;
    protected $table='report';
    protected $primaryKey='id_report';
    protected $keyType='integer';
    public $timestamps=true;
    const CREATED_AT='created_at';
    const UPDATED_AT='updated_at';
    const DELETED_AT='deleted_at';
    public $incrementing=true;
}
