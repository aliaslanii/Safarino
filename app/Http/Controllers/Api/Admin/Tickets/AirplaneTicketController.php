<?php

namespace App\Http\Controllers\Api\Admin\Tickets;

use App\Http\Controllers\Controller;
use App\Http\Requests\AirplaneTicketRequest;
use App\Models\AirplaneTicket;
use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class AirplaneTicketController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/admin/AirplaneTicket/index",
     *     summary="All AirplaneTicket",
     *     tags={"AirplaneTicket"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response="200", description="AirplaneTicket detail successfully"),
     * )
     */
    public function index()
    {
        try {
            return AirplaneTicket::all();
        } catch (\Throwable $th) {
            return Response::json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    /**
     * @OA\Get(
     *     path="/api/admin/AirplaneTicket/create",
     *     summary="create Test AirplaneTicket Data",
     *     tags={"AirplaneTicket"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="Count",
     *         in="query",
     *         description="Count Test Data => AirplaneTicket",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ), 
     *     @OA\Response(response="500", description="Server Error"),
     *     @OA\Response(response="200", description="AirplaneTicket create Test Data successfully"),
     * )
    */
    public function create(Request $request)
    { 
        try {
            $AirplaneTicket = AirplaneTicket::factory()->count(30)->create();
            return Response::json([
                'status' => true,
                'AirplaneTicket' =>  $AirplaneTicket
            ]);
        } catch (\Throwable $th) {
            return Response::json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    /**
     * @OA\Post(
     *     path="/api/admin/AirplaneTicket/store",
     *     summary="Create a AirplaneTicket",
     *     tags={"AirplaneTicket"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="adultPrice",
     *         in="query",
     *         description="adultPrice AirplaneTicket",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),  
     *     @OA\Parameter(
     *         name="arrivalTime",
     *         in="query",
     *         description="arrivalTime TrainTicket",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),  
     *     @OA\Parameter(
     *         name="arrivalDate",
     *         in="query",
     *         description="arrivalDate TrainTicket",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ), 
     *     @OA\Parameter(
     *         name="departureTime",
     *         in="query",
     *         description="departureTime TrainTicket",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ), 
     *      @OA\Parameter(
     *         name="departureDate",
     *         in="query",
     *         description="departureDate TrainTicket",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ), 
     *     @OA\Parameter(
     *         name="capacity",
     *         in="query",
     *         description="capacity AirplaneTicket",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ), 
     *     @OA\Parameter(
     *         name="airline_id",
     *         in="query",
     *         description="airline AirplaneTicket",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ), 
     *     @OA\Parameter(
     *         name="airport_id",
     *         in="query",
     *         description="airport AirplaneTicket",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ), 
     *     @OA\Parameter(
     *         name="maxAllowedBaggage",
     *         in="query",
     *         description="maxAllowedBaggage AirplaneTicket",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ), 
     *     @OA\Parameter(
     *         name="flightNumber",
     *         in="query",
     *         description="flightNumber AirplaneTicket",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ), 
     *     @OA\Parameter(
     *         name="aircraft",
     *         in="query",
     *         description="aircraft AirplaneTicket",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),   
     *     @OA\Parameter(
     *         name="origin",
     *         in="query",
     *         description="origin AirplaneTicket",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),  
     *     @OA\Parameter(
     *         name="destination",
     *         in="query",
     *         description="destination AirplaneTicket",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),  
     *     @OA\Parameter(
     *         name="type",
     *         in="query",
     *         description="type AirplaneTicket (Charter , Systemic)",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),  
     *     @OA\Parameter(
     *         name="cabinclass",
     *         in="query",
     *         description="cabinclass AirplaneTicket (Economy , Business , Firstclass)",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),  
     *     @OA\Response(response="200", description="AirplaneTicket Store successfully"),
     *     @OA\Response(response="409", description="AirplaneTicket Validate Error"),
     *     @OA\Response(response="500", description="Server Error"),
     * )
     */
    public function store(Request $request)
    {
        try {
            $AirplaneTicketRequest = new AirplaneTicketRequest();
            $Validator = Validator::make($request->all(), $AirplaneTicketRequest->rules(), $AirplaneTicketRequest->messages());
            if ($Validator->fails()) {
                return Response::json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $Validator->errors()
                ], 409);
            }
            $AirplaneTicket = new AirplaneTicket();
            $AirplaneTicket->adultPrice = $request->adultPrice;
            $AirplaneTicket->arrivalDate = Verta::parse($request->arrivalDate)->datetime();
            $AirplaneTicket->arrivalTime = $request->arrivalTime;
            $AirplaneTicket->departureDate =  Verta::parse($request->departureDate)->datetime();
            $AirplaneTicket->departureTime = $request->departureTime;
            $AirplaneTicket->capacity = $request->capacity;
            $AirplaneTicket->aircraft = $request->aircraft;
            $AirplaneTicket->maxAllowedBaggage = $request->maxAllowedBaggage;
            $AirplaneTicket->flightNumber = $request->flightNumber;
            $AirplaneTicket->airline_id = $request->airline_id;
            $AirplaneTicket->airport_id = $request->airport_id;
            $AirplaneTicket->origin = $request->origin;
            $AirplaneTicket->destination = $request->destination;
            $AirplaneTicket->type = $request->type;
            $AirplaneTicket->cabinclass = $request->cabinclass;
            $AirplaneTicket->save();
            return Response::json([
                'status' => true,
                'message' => 'Done',
                'data' => $AirplaneTicket
            ], 200);
        } catch (\Throwable $th) {
            return Response::json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    /**
     * @OA\Get(
     *     path="/api/admin/AirplaneTicket/show",
     *     summary="show a AirplaneTicket",
     *     tags={"AirplaneTicket"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="id AirplaneTicket",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),    
     *     @OA\Response(response="200", description="AirplaneTicket detail successfully"),
     * )
     */
    public function show(Request $request)
    {
        try {
            $AirplaneTicket = AirplaneTicket::findOrfail($request->id);
            return Response::json([
                'status' => true,
                'data' => $AirplaneTicket
            ], 200);
        } catch (\Throwable $th) {
            return Response::json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    /**
     * @OA\Get(
     *     path="/api/admin/AirplaneTicket/edit",
     *     summary="edit a AirplaneTicket",
     *     tags={"AirplaneTicket"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="id AirplaneTicket",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),    
     *     @OA\Response(response="200", description="AirplaneTicket detail successfully"),
     * )
     */
    public function edit(Request $request)
    {
        try {
            $AirplaneTicket = AirplaneTicket::findOrfail($request->id);
            return Response::json([
                'status' => true,
                'data' => $AirplaneTicket
            ], 200);
        } catch (\Throwable $th) {
            return Response::json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    /**
     * @OA\Put(
     *     path="/api/admin/AirplaneTicket/update",
     *     summary="update a AirplaneTicket",
     *     tags={"AirplaneTicket"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="id AirplaneTicket",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ), 
     *     @OA\Parameter(
     *         name="adultPrice",
     *         in="query",
     *         description="adultPrice AirplaneTicket",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),  
     *     @OA\Parameter(
     *         name="arrivalTime",
     *         in="query",
     *         description="arrivalTime TrainTicket",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),  
     *     @OA\Parameter(
     *         name="arrivalDate",
     *         in="query",
     *         description="arrivalDate TrainTicket",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ), 
     *     @OA\Parameter(
     *         name="departureTime",
     *         in="query",
     *         description="departureTime TrainTicket",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ), 
     *      @OA\Parameter(
     *         name="departureDate",
     *         in="query",
     *         description="departureDate TrainTicket",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ), 
     *     @OA\Parameter(
     *         name="capacity",
     *         in="query",
     *         description="capacity AirplaneTicket",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ), 
     *     @OA\Parameter(
     *         name="airline_id",
     *         in="query",
     *         description="airline AirplaneTicket",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ), 
     *     @OA\Parameter(
     *         name="airport_id",
     *         in="query",
     *         description="airport AirplaneTicket",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ), 
     *     @OA\Parameter(
     *         name="maxAllowedBaggage",
     *         in="query",
     *         description="maxAllowedBaggage AirplaneTicket",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ), 
     *     @OA\Parameter(
     *         name="flightNumber",
     *         in="query",
     *         description="flightNumber AirplaneTicket",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ), 
     *     @OA\Parameter(
     *         name="aircraft",
     *         in="query",
     *         description="aircraft AirplaneTicket",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),   
     *     @OA\Parameter(
     *         name="origin",
     *         in="query",
     *         description="origin AirplaneTicket",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),  
     *     @OA\Parameter(
     *         name="destination",
     *         in="query",
     *         description="destination AirplaneTicket",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),  
     *     @OA\Parameter(
     *         name="type",
     *         in="query",
     *         description="type AirplaneTicket (Charter , Systemic)",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),  
     *     @OA\Parameter(
     *         name="cabinclass",
     *         in="query",
     *         description="cabinclass AirplaneTicket (Economy , Business , Firstclass)",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="AirplaneTicket Store successfully"),
     *     @OA\Response(response="409", description="AirplaneTicket Validate Error"),
     *     @OA\Response(response="500", description="Server Error"),
     * )
     */
    public function update(Request $request)
    {
        try {
            $AirplaneTicketRequest = new AirplaneTicketRequest();
            $Validator = Validator::make($request->all(), $AirplaneTicketRequest->rules(), $AirplaneTicketRequest->messages());
            if ($Validator->fails()) {
                return Response::json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $Validator->errors()
                ], 409);
            }
            $AirplaneTicket = AirplaneTicket::findOrfail($request->id);
            $AirplaneTicket->adultPrice = $request->adultPrice;
            $AirplaneTicket->arrivalDate = Verta::parse($request->arrivalDate)->datetime();
            $AirplaneTicket->arrivalTime = $request->arrivalTime;
            $AirplaneTicket->departureDate =  Verta::parse($request->departureDate)->datetime();
            $AirplaneTicket->departureTime = $request->departureTime;
            $AirplaneTicket->capacity = $request->capacity;
            $AirplaneTicket->aircraft = $request->aircraft;
            $AirplaneTicket->maxAllowedBaggage = $request->maxAllowedBaggage;
            $AirplaneTicket->flightNumber = $request->flightNumber;
            $AirplaneTicket->airline_id = $request->airline_id;
            $AirplaneTicket->airport_id = $request->airport_id;
            $AirplaneTicket->origin = $request->origin;
            $AirplaneTicket->destination = $request->destination;
            $AirplaneTicket->type = $request->type;
            $AirplaneTicket->cabinclass = $request->cabinclass;
            $AirplaneTicket->save();
            return Response::json([
                'status' => true,
                'data' => $AirplaneTicket
            ], 200);
        } catch (\Throwable $th) {
            return Response::json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/admin/AirplaneTicket/destroy",
     *     summary="Delete a AirplaneTicket",
     *     tags={"AirplaneTicket"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="id AirplaneTicket",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="AirplaneTicket detail successfully"),
     * )
     */
    public function destroy(Request $request)
    {
        try {
            $AirplaneTicket = AirplaneTicket::findOrfail($request->id);
            $AirplaneTicket->delete();
            return Response::json([
                'status' => true,
                'data' => $AirplaneTicket
            ], 200);
        } catch (\Throwable $th) {
            return Response::json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    /**
     * @OA\Put(
     *     path="/api/admin/AirplaneTicket/restore",
     *     summary="Restore a AirplaneTicket",
     *     tags={"AirplaneTicket"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="id AirplaneTicket",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="AirplaneTicket detail successfully"),
     * )
     */
    public function restore(Request $request)
    {
        try {
            $AirplaneTicket = AirplaneTicket::where('id', $request->id)->restore();
            return Response::json([
                'status' => true,
                'data' => $AirplaneTicket
            ], 200);
        } catch (\Throwable $th) {
            return Response::json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
