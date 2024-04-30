<?php

namespace App\Http\Controllers\Api\Admin\Tickets;

use App\Http\Controllers\Controller;
use App\Http\Requests\TrainTicketRequest;
use App\Models\TrainTicket;
use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class TrainTicketController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/admin/TrainTicket/index",
     *     summary="All TrainTicket",
     *     tags={"TrainTicket"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response="200", description="TrainTicket detail successfully"),
     *     @OA\Response(response="500", description="Server Error"),
     * )
     */
    public function index()
    {
        try {
            return TrainTicket::all();
        } catch (\Throwable $th) {
            return Response::json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    /**
     * @OA\Get(
     *     path="/api/admin/TrainTicket/create",
     *     summary="create Test City Data",
     *     tags={"TrainTicket"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="Count",
     *         in="query",
     *         description="Count Test Data => TrainTicket",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ), 
     *     @OA\Response(response="500", description="Server Error"),
     *     @OA\Response(response="200", description="TrainTicket create Test Data successfully"),
     * )
    */
    public function create(Request $request)
    {
        try {
            $TrainTicket = TrainTicket::factory()->count($request->Count)->create();
            return Response::json([
                'status' => true,
                'TrainTicket' =>  $TrainTicket
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
     *     path="/api/admin/TrainTicket/store",
     *     summary="Create a TrainTicket",
     *     tags={"TrainTicket"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="adultPrice",
     *         in="query",
     *         description="adultPrice TrainTicket",
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
     *         description="capacity TrainTicket",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ), 
     *     @OA\Parameter(
     *         name="trainnumber",
     *         in="query",
     *         description="airline TrainTicket",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ), 
     *     @OA\Parameter(
     *         name="railcompanie_id",
     *         in="query",
     *         description="railcompanie TrainTicket",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),  
     *     @OA\Parameter(
     *         name="origin",
     *         in="query",
     *         description="origin TrainTicket",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),  
     *     @OA\Parameter(
     *         name="destination",
     *         in="query",
     *         description="destination TrainTicket",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),  
     *     @OA\Parameter(
     *         name="type",
     *         in="query",
     *         description="type TrainTicket (4-seater-coupe , 6-seater-coupe , 4-row-hall)",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),  
     *     @OA\Response(response="200", description="TrainTicket Store successfully"),
     *     @OA\Response(response="409", description="TrainTicket Validate Error"),
     *     @OA\Response(response="500", description="Server Error"),
     * )
     */
    public function store(Request $request)
    {
        try {
            $TrainTicketRequest = new TrainTicketRequest();
            $Validator = Validator::make($request->all(), $TrainTicketRequest->rules(), $TrainTicketRequest->messages());
            if ($Validator->fails()) {
                return Response::json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $Validator->errors()
                ], 409);
            }
            $TrainTicket = new TrainTicket();
            $TrainTicket->adultPrice = $request->adultPrice;
            $TrainTicket->arrivalDate = Verta::parse($request->arrivalDate)->datetime();
            $TrainTicket->arrivalTime = $request->arrivalTime;
            $TrainTicket->departureDate =  Verta::parse($request->departureDate)->datetime();
            $TrainTicket->departureTime = $request->departureTime;
            $TrainTicket->capacity = $request->capacity;
            $TrainTicket->trainnumber = $request->trainnumber;
            $TrainTicket->railcompanie_id = $request->railcompanie_id;
            $TrainTicket->origin = $request->origin;
            $TrainTicket->destination = $request->destination;
            $TrainTicket->type = $request->type;
            $TrainTicket->save();
            return Response::json([
                'status' => true,
                'message' => 'Done',
                'data' => $TrainTicket
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
     *     path="/api/admin/TrainTicket/show",
     *     summary="show a TrainTicket",
     *     tags={"TrainTicket"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="id TrainTicket",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),    
     *     @OA\Response(response="200", description="TrainTicket detail successfully"),
     * )
     */
    public function show(Request $request)
    {
        try {
            $TrainTicket = TrainTicket::findOrfail($request->id);
            $Response = [];
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
    /**
     * @OA\Get(
     *     path="/api/admin/TrainTicket/edit",
     *     summary="edit a TrainTicket",
     *     tags={"TrainTicket"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="id TrainTicket",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),    
     *     @OA\Response(response="200", description="TrainTicket detail successfully"),
     * )
     */
    public function edit(Request $request)
    {
        try {
            $TrainTicket = TrainTicket::findOrfail($request->id);
            $Response = [];
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
    /**
     * @OA\Put(
     *     path="/api/admin/TrainTicket/update",
     *     summary="update a TrainTicket",
     *     tags={"TrainTicket"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="id TrainTicket",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ), 
     *    @OA\Parameter(
     *         name="adultPrice",
     *         in="query",
     *         description="adultPrice TrainTicket",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),  
     *      @OA\Parameter(
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
     *         description="capacity TrainTicket",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ), 
     *     @OA\Parameter(
     *         name="trainnumber",
     *         in="query",
     *         description="airline TrainTicket",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ), 
     *     @OA\Parameter(
     *         name="railcompanie_id",
     *         in="query",
     *         description="railcompanie TrainTicket",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),  
     *     @OA\Parameter(
     *         name="origin",
     *         in="query",
     *         description="origin TrainTicket",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),  
     *     @OA\Parameter(
     *         name="destination",
     *         in="query",
     *         description="destination TrainTicket",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),  
     *     @OA\Parameter(
     *         name="type",
     *         in="query",
     *         description="type TrainTicket (4-seater-coupe , 6-seater-coupe , 4-row-hall)",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),   
     *     @OA\Response(response="200", description="TrainTicket Update successfully"),
     *     @OA\Response(response="409", description="TrainTicket Validate Error"),
     *     @OA\Response(response="500", description="Server Error"),
     * )
     */
    public function update(Request $request)
    {
        try {
            $TrainTicketRequest = new TrainTicketRequest();
            $Validator = Validator::make($request->all(), $TrainTicketRequest->rules(), $TrainTicketRequest->messages());
            if ($Validator->fails()) {
                return Response::json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $Validator->errors()
                ], 409);
            }
            $TrainTicket = TrainTicket::findOrfail($request->id);
            $TrainTicket->adultPrice = $request->adultPrice;
            $TrainTicket->arrivalDate = Verta::parse($request->arrivalDate)->datetime();
            $TrainTicket->arrivalTime = $request->arrivalTime;
            $TrainTicket->departureDate =  Verta::parse($request->departureDate)->datetime();
            $TrainTicket->departureTime = $request->departureTime;
            $TrainTicket->capacity = $request->capacity;
            $TrainTicket->trainnumber = $request->trainnumber;
            $TrainTicket->railcompanie_id = $request->railcompanie_id;
            $TrainTicket->origin = $request->origin;
            $TrainTicket->destination = $request->destination;
            $TrainTicket->type = $request->type;
            $TrainTicket->save();
            return Response::json([
                'status' => true,
                'message' => 'Done',
                'data' => $TrainTicket
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
     *     path="/api/admin/TrainTicket/destroy",
     *     summary="Delete a TrainTicket",
     *     tags={"TrainTicket"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="id TrainTicket",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="TrainTicket detail successfully"),
     * )
     */
    public function destroy(Request $request)
    {
        try {
            $TrainTicket = TrainTicket::findOrfail($request->id);
            $TrainTicket->delete();
            return Response::json([
                'status' => true,
                'data' => $TrainTicket
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
     *     path="/api/admin/TrainTicket/restore",
     *     summary="Restore a TrainTicket",
     *     tags={"TrainTicket"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="id TrainTicket",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="TrainTicket detail successfully"),
     * )
     */
    public function restore(Request $request)
    {
        try {
            $TrainTicket = TrainTicket::where('id', $request->id)->restore();
            return Response::json([
                'status' => true,
                'data' => $TrainTicket
            ], 200);
        } catch (\Throwable $th) {
            return Response::json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
