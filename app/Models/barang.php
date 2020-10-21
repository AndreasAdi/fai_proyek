<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class barang extends Model
{
    use SoftDeletes;
    protected $table='barang';
    protected $primaryKey='id_barang';
    protected $keyType='integer';
    public $timestamps=true;
    const CREATED_AT='created_at';
    const UPDATED_AT='updated_at';
    const DELETED_AT='deleted_at';
    public $incrementing=true;
}
