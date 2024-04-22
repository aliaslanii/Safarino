<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

use Illuminate\Database\Eloquent\SoftDeletes;

class AirplaneTicket extends Model
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
    public function airline() : BelongsTo
    {
        return $this->belongsTo(Airlines::class,'airline_id');
    }
    public function airport() : BelongsTo
    {
        return $this->belongsTo(Airport::class,'airport_id');
    } 
    public function passenger() : BelongsToMany
    {
        return $this->belongsToMany(Passenger::class,'passenger_airplanetickets','airplaneticket_id','passenger_id');
    }
}