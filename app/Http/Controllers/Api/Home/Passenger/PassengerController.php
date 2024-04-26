<?php

namespace App\Http\Controllers\Api\Home\Passenger;

use App\Http\Controllers\Controller;
use App\checker;
use App\Http\Requests\PassengerRequest;
use App\Models\Passenger;
use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class PassengerController extends Controller
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
    /**
     * @OA\Get(
     *     path="/api/Passenger/create",
     *     summary="Create 30 Fake Data in Passenger",
     *     tags={"Passenger"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response="200", description="Create 30 Fake Data in Passenger"),
     *     @OA\Response(response="500", description="Server Error")
     * )
    */
    public function create()
    {
        return Passenger::factory()->count(30)->create();
    }
    /**
     * @OA\Post(
     *     path="/api/Passenger/store",
     *     summary="Create a Passenger",
     *     tags={"Passenger"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="firstName",
     *         in="query",
     *         description="firstName Passenger",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),    
     *     @OA\Parameter(
     *         name="lastName",
     *         in="query",
     *         description="lastName Passenger",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),  
     *     @OA\Parameter(
     *         name="nationalcode",
     *         in="query",
     *         description="nationalcode Passenger",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),    
     *     @OA\Parameter(
     *         name="gender",
     *         in="query",
     *         description="gender Passenger (male,femail)",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ), 
     *     @OA\Parameter(
     *         name="birthday",
     *         in="query",
     *         description="birthday Passenger",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ), 
     *     @OA\Response(response="200", description="Passenger detail successfully"),
     *     @OA\Response(response="409", description="TrainTicket Validate Error"), 
     *     @OA\Response(response="500", description="Server Error"),
     * )
     */
    public function store(Request $request)
    {
        try {
            $PassengerRequest = new PassengerRequest();
            $Validator = Validator::make($request->all(), $PassengerRequest->rules());
            if ($Validator->fails()) {
                return Response::json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $Validator->errors()
                ], 409);
            }
            $Passenger = new Passenger();
            $Passenger->firstName = $request->firstName;
            $Passenger->lastName = $request->lastName;
            $Passenger->birthday = Verta::parse($request->birthday)->datetime();
            $Passenger->nationalcode = $request->nationalcode;
            $Passenger->gender = $request->gender;
            $Passenger->user_id = Auth::user()->id;
            $Passenger->save();
            return Response::json([
                'status' => true,
                'message' => 'Done',
                'data' => $Passenger
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
     *     path="/api/Passenger/show",
     *     summary="User Passengers",
     *     tags={"Passenger"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response="200", description="get Passengers User successfully"),
     *     @OA\Response(response="500", description="Server Error"),
     * )
    */
    public function show()
    {
        try {
            $Response = [];
            $Passengers =  Auth::user()->Passenger;
            foreach($Passengers as $Passenger)
            {
                $PassengerData = [
                    "firstName" => $Passenger->firstName,
                    "lastName" => $Passenger->lastName,
                    "nationalcode" => $Passenger->nationalcode,
                    "birthday" => verta($Passenger->birthday)->format('Y/m/d'),
                    "gender" => $Passenger->gender,
                    "user_id" => $Passenger->User,
                ];
                $Response[] = $PassengerData;
            }
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
     *     path="/api/Passenger/edit",
     *     summary="edit a Passenger",
     *     tags={"Passenger"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="id Passenger",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),    
     *     @OA\Response(response="200", description="Passenger detail successfully"),
     *     @OA\Response(response="500", description="Server Error"),
     * )
     */
    public function edit(Request $request)
    {
        try {
            $Response = [];
            $Passenger = Passenger::findOrfail($request->id);
            $PassengerData = [
                "firstName" => $Passenger->firstName,
                "lastName" => $Passenger->lastName,
                "nationalcode" => $Passenger->nationalcode,
                "birthday" => verta($Passenger->birthday)->format('Y/m/d'),
                "gender" => $Passenger->gender,
                "user_id" => $Passenger->User,
            ];
            $Response[] = $PassengerData;
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
     *     path="/api/Passenger/update",
     *     summary="Update a Passenger",
     *     tags={"Passenger"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="id Passenger",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),    
     *     @OA\Parameter(
     *         name="firstName",
     *         in="query",
     *         description="firstName Passenger",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),    
     *     @OA\Parameter(
     *         name="lastName",
     *         in="query",
     *         description="lastName Passenger",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),  
     *     @OA\Parameter(
     *         name="nationalcode",
     *         in="query",
     *         description="nationalcode Passenger",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),    
     *     @OA\Parameter(
     *         name="gender",
     *         in="query",
     *         description="gender Passenger (male,femail)",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ), 
     *     @OA\Parameter(
     *         name="birthday",
     *         in="query",
     *         description="birthday Passenger",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Passenger detail successfully"),
     *     @OA\Response(response="409", description="TrainTicket Validate Error"), 
     *     @OA\Response(response="500", description="Server Error"),
     * )
     */
    public function update(Request $request)
    {
        try {
            $PassengerRequest = new PassengerRequest();
            $Validator = Validator::make($request->all(), $PassengerRequest->rules());
            if ($Validator->fails()) {
                return Response::json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $Validator->errors()
                ], 409);
            }
            $Passenger = Passenger::findOrfail($request->id);
            $Passenger->firstName = $request->firstName;
            $Passenger->lastName = $request->lastName;
            $Passenger->birthday = Verta::parse($request->birthday)->datetime();
            $Passenger->nationalcode = $request->nationalcode;
            $Passenger->gender = $request->gender;
            $Passenger->user_id = Auth::user()->id;
            $Passenger->save();
            return Response::json([
                'status' => true,
                'data' => $Passenger
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
     *     path="/api/Passenger/destroy",
     *     summary="Delete a Passenger",
     *     tags={"Passenger"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="id Passenger",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Passenger detail successfully"),
     *     @OA\Response(response="500", description="Server Error"),
     * )
     */
    public function destroy(Request $request)
    {
        try {
            $Passenger = Passenger::findOrfail($request->id);
            $Passenger->delete();
            return Response::json([
                'status' => true,
                'data' => $Passenger
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
     *     path="/api/Passenger/restore",
     *     summary="Restore a Passenger",
     *     tags={"Passenger"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="id Passenger",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Passenger detail successfully"),
     *     @OA\Response(response="500", description="Server Error"),
     * )
     */
    public function restore(Request $request)
    {
        try {
            $Passenger = Passenger::where('id', $request->id)->restore();
            return Response::json([
                'status' => true,
                'data' => $Passenger
            ], 200);
        } catch (\Throwable $th) {
            return Response::json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
