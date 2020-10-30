<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class chat extends Model
{
    protected $table='chat';
    const CREATED_AT='created_at';
    const UPDATED_AT='updated_at';
    public $timestamps=true;
}
