<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrainTicket extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function cityorigin() : BelongsTo
    {
        return $this->belongsTo(City::class,'origin');
    }
    public function citydestination() : BelongsTo
    {
        return $this->belongsTo(City::class,'destination');
    }
    public function Railcompanie() : BelongsTo
    {
        return $this->belongsTo(Railcompanie::class,'railcompanie_id');
    }
    public function passenger() : BelongsToMany
    {
        return $this->belongsToMany(Passenger::class,'passenger_traintickets','trainticket_id','passenger_id');
    }
}
