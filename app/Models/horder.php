<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class horder extends Model
{
    use SoftDeletes;
    protected $table='horder';
    protected $primaryKey='id_horder';
    protected $keyType='integer';
    public $timestamps=true;
    const CREATED_AT='created_at';
    const UPDATED_AT='updated_at';
    const DELETED_AT='deleted_at';
    public $incrementing=true;
    public function dorders() {
        return $this->hasMany('App\Models\dorder','id_horder');
    }
}
