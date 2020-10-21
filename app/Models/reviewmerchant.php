<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class reviewmerchant extends Model
{
    protected $table='reviewmerchant';
    protected $primaryKey='id_review';
    protected $keyType='integer';
    public $timestamps=true;
    const CREATED_AT='created_at';
    const UPDATED_AT='updated_at';
    public $incrementing=true;
}
