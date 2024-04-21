<?php

namespace App;

use App\Models\AirplaneTicket;
use App\Models\Passenger;
use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Support\Facades\Auth;

class checker
{
    public function checkPassenger($AirplaneTicket,$Passengers)
    {
     
    }
    public function checkData($request)
    {
        $result = [];
        foreach ($request->passengers as $Passenger) {
            if ($this->validateItem($Passenger) != false) 
            {
                $result[] = $this->validateItem($Passenger)->id;
            } else{
                $newPassenger = new Passenger();
                $newPassenger->user_id =  Auth::user()->id;
                $newPassenger->firstName = $Passenger['firstName'];
                $newPassenger->lastName = $Passenger['lastName'];
                $newPassenger->birthday = Verta::parse($Passenger['birthday'])->datetime();
                $newPassenger->nationalcode = $Passenger['nationalcode'];
                $newPassenger->gender = $Passenger['gender'];
                $newPassenger->save();                
                $result[] = $newPassenger->id;
            }
        }
        return $result;
    }

    private function validateItem($Passenger)
    {
        $result = Passenger::where('user_id', '=', Auth::user()->id)
        ->where('nationalcode', '=', $Passenger['nationalcode'])
        ->first();
        if ($result != null) {
            return $result;
        } else {
            return false;
        }
    }
}
