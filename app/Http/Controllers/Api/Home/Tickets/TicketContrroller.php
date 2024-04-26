<?php

namespace App\Http\Controllers\Api\Home\Tickets;

use App\Http\Controllers\Controller;
use App\Models\AirplaneTicket;
use App\Models\TrainTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class TicketContrroller extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/ticket/airplane",
     *     summary="detail AirplaneTickets",
     *     tags={"Ticket Home"},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="id AirplaneTicket",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),   
     *     @OA\Response(response="200", description="AirplaneTicket detail successfully"),
     * )
     */
    public function airplaneTicket(Request $request)
    {
        try {
            $Response = [];
            $AirplaneTicket = AirplaneTicket::findOrfail($request->id);
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
            return Response::json([
                'status' => true,
                'data' => $Response
            ], 200);
        } catch (\Throwable $th) {
            return Response::json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    /**
     * @OA\Post(
     *     path="/api/ticket/trin",
     *     summary="detail TrainTicket",
     *     tags={"Ticket Home"},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="id AirplaneTicket",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),   
     *     @OA\Response(response="200", description="TrainTicket detail successfully"),
     * )
     */
    public function trinTicket(Request $request)
    {
        try {
            $Response = [];
            $TrainTicket = TrainTicket::findOrfail($request->id);
            $TrainTicketData = [
                "adultPrice" => number_format($TrainTicket->adultPrice),
                "DateTime" => verta($request->arrivalTime)->format('l، d F'),
                "arrivalTime" => $TrainTicket->arrivalTime,
                "arrivalDate" => verta($TrainTicket->arrivalDate)->format('m/d - l'),
                "departureTime" => $TrainTicket->departureTime, 
                "departureDate" => verta($TrainTicket->departureDate)->format('m/d - l'),
                "capacity" => $TrainTicket->capacity,
                "trainnumber" => $TrainTicket->trainnumber,
                "origin" => $TrainTicket->cityorigin->name,
                "destination" => $TrainTicket->citydestination->name,
                'Railcompanie' => $TrainTicket->Railcompanie->name,
                'Railcompanie-photo' => $TrainTicket->Railcompanie->profile_photo_path,
                'type' => $TrainTicket->type,
                'isCompleted' => $TrainTicket->isCompleted,
            ];
            $Response[] = $TrainTicketData;
            return Response::json([
                'status' => true,
                'data' => $Response
            ], 200);
        } catch (\Throwable $th) {
            return Response::json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
