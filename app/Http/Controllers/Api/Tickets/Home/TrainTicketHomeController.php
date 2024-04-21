<?php

namespace App\Http\Controllers\Api\Tickets\Home;

use App\Http\Controllers\Controller;
use App\Models\TrainTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class TrainTicketHomeController extends Controller
{
     /**
     * @OA\Post(
     *     path="/api/TrainTicket/search",
     *     summary="Search TrainTickets",
     *     tags={"Search"},
     *     @OA\Parameter(
     *         name="arrivalTime",
     *         in="query",
     *         description="arrivalTime TrainTicket",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),  
     *     @OA\Parameter(
     *         name="origin",
     *         in="query",
     *         description="id city => origin TrainTicket",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),  
     *     @OA\Parameter(
     *         name="destination",
     *         in="query",
     *         description="id city => destination TrainTicket",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),   
     *     @OA\Response(response="200", description="TrainTicket detail successfully"),
     *     @OA\Response(response="409", description="TrainTicket Validate Error"),
     *     @OA\Response(response="500", description="Server Error"),
     * )
     */
    public function search(Request $request)
    {
        try {
            $TrainTickets = TrainTicket::where('origin', $request->origin)
                ->where('destination', $request->destination)
                ->where('arrivalTime', 'like', '%' . $request->arrivalDate . '%')
                ->get();
            $Response = [];
            foreach ($TrainTickets as $TrainTicket) {
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
}
