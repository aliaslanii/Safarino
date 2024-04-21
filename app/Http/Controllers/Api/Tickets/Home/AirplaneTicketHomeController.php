<?php

namespace App\Http\Controllers\Api\Tickets\Home;

use App\Http\Controllers\Controller;
use App\Models\AirplaneTicket;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class AirplaneTicketHomeController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/AirplaneTicket/search",
     *     summary="Search AirplaneTickets",
     *     tags={"Search"},
     *     @OA\Parameter(
     *         name="arrivalTime",
     *         in="query",
     *         description="arrivalTime AirplaneTicket",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),  
     *     @OA\Parameter(
     *         name="origin",
     *         in="query",
     *         description="id city => origin AirplaneTicket",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),  
     *     @OA\Parameter(
     *         name="destination",
     *         in="query",
     *         description="id city => destination AirplaneTicket",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),   
     *     @OA\Response(response="200", description="AirplaneTicket detail successfully"),
     * )
     */
    public function search(Request $request)
    {
        try {
            $AirplaneTickets = AirplaneTicket::where('origin', $request->origin)
                ->where('destination', $request->destination)
                ->where('arrivalTime', 'like', '%' . $request->arrivalDate . '%')
                ->get();
            $Response = [];
            foreach ($AirplaneTickets as $AirplaneTicket) {
                $AirplaneTicketData = [
                    "adultPrice" => number_format($AirplaneTicket->adultPrice),
                    "DateTime" => verta($request->arrivalTime)->format('l، d F'),
                    "arrivalTime" => $AirplaneTicket->arrivalTime,
                    "arrivalDate" => verta($AirplaneTicket->arrivalDate)->format('m/d - l'),
                    "departureTime" => $AirplaneTicket->departureTime, 
                    "departureDate" => verta($AirplaneTicket->departureDate)->format('m/d - l'),
                    "maxAllowedBaggage" => $AirplaneTicket->maxAllowedBaggage,
                    "aircraft" => $AirplaneTicket->aircraft,
                    "capacity" => $AirplaneTicket->capacity,
                    "flightNumber" => $AirplaneTicket->flightNumber,
                    "origin" => $AirplaneTicket->cityorigin->name,
                    "destination" => $AirplaneTicket->citydestination->name,
                    'airport' => $AirplaneTicket->airport->name,
                    'airline' => $AirplaneTicket->airline->name,
                    'airline-photo' => $AirplaneTicket->airline->profile_photo_path,
                    'type' => $AirplaneTicket->type,
                    'cabinclass' => $AirplaneTicket->cabinclass,
                    'isCompleted' => $AirplaneTicket->isCompleted,
                ];
                $Response[] = $AirplaneTicketData;
            }
            return Response::json([
                'data' => $Response,
            ], 200);
        } catch (\Throwable $th) {
            return Response::json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
