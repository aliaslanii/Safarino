<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Order extends Model
{
    use HasFactory;

    public function airplaneTicket(): BelongsTo
    {
        return $this->belongsTo(AirplaneTicket::class,'airplanetickets_id');
    }
    public function trainTicket(): BelongsTo
    {
        return $this->belongsTo(TrainTicket::class,'trainticket_id');
    }
}
