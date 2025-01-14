<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['requester_name','destination','departure','arrival','departure','user_id','status_id'];

    /**
     * Get the status that owns the order.
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }


    /**
     * Get the user that owns the order.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
