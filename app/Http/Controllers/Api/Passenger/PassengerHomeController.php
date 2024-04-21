<?php

namespace App\Http\Controllers\Api\Passenger;

use App\Http\Controllers\Controller;
use App\checker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class PassengerHomeController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/passenger/Add",
     *     summary="Create|found Passengers",
     *     tags={"Passenger Ticket"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="passengers", type="array", @OA\Items(
     *                     @OA\Property(property="firstName", type="string"),
     *                     @OA\Property(property="lastName", type="string"),
     *                     @OA\Property(property="birthday", type="string", format="date"),
     *                     @OA\Property(property="nationalcode", type="string"),
     *                     @OA\Property(property="gender", type="string")
     *                 )),
     *             )
     *         )
     *     ),
     *      @OA\Response(response="200", description="passenger Create|Found successfully"),
     * )
     */
    public function addPassenger(Request $request)
    {
        try {
            $DataChecker = new checker();
            $Passengers = $DataChecker->checkData($request);
            return Response::json([
                'status' => true,
                'message' => 'Done',
                'data' => $Passengers
            ], 200);
        } catch (\Throwable $th) {
            return Response::json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
