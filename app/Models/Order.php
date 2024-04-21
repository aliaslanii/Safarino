<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Order extends Model
{
    use HasFactory;

    public function trainTicketOwner(): HasOneThrough
    {
        return $this->hasOneThrough(Passenger::class, TrainTicket::class);
    }
}
