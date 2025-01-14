<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    CONST APROVADO = 2;
    CONST CANCELADO = 3;
    CONST ORDER_ALLOWED_STATUS_CHANGES = 
    [
        self::APROVADO,
        self::CANCELADO
    ];
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'status';
}
