<?php

namespace App\Http\Controllers\Api\Admin\Airport;

use App\helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\AirportRequest;
use App\Models\Airport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class AirportController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/admin/Airport/index",
     *     summary="index Airport",
     *     tags={"Airport"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response="200", description="Airport Show successfully"),
     * )
     */
    public function index()
    {
        try {
            return Response::json([
                'status' => true,
                'Airport' =>  Airport::all()
            ]);
        } catch (\Throwable $th) {
            return Response::json([
                'status' => false,
                'message' => $th->getMessage()
            ]);
        }
    }
    /**
     * Upload an image.
     *
     * @OA\Post(
     *      path="/api/admin/Airport/store",
     *      tags={"Airport"},
     *      summary="Store Airport",
     *      description="Store a Airport",
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="Name Airport",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Airport Store successfully"),
     *     @OA\Response(response="409", description="Airport Validate Error"),
     *     @OA\Response(response="500", description="Server Error"),
     * )
     */
    public function store(Request $request)
    {
        try {
            $AirportRequest = new AirportRequest();
            $Validator = Validator::make($request->all(),$AirportRequest->rules());
            if ($Validator->fails()) {
                return Response::json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $Validator->errors()
                ], 409);
            }
            $Airport = new Airport();
            $Airport->name = $request->name;
            $Airport->save();
            return Response::json([
                'status' => true,
                'image' => $Airport
            ]);
        } catch (\Throwable $th) {
            return Response::json([
                'status' => false,
                'message' => $th->getMessage()
            ]);
        }
    }
    /**
     * @OA\Get(
     *     path="/api/admin/Airport/show",
     *     summary="show a Airport",
     *     tags={"Airport"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="id Airport",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),    
     *     @OA\Response(response="200", description="Airport detail successfully"),
     * )
     */
    public function show(Request $request)
    {
        try {
            $Airport = Airport::find($request->id);
            $Response = [];
            if($Airport)
            {
                $AirportData = [
                    "Name" => $Airport->name,
                ];
            }else{
                $AirportData = [
                    "data" => null
                ];
            }
            $Response[] = $AirportData;
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
     *     path="/api/admin/Airport/edit",
     *     summary="edit a Airport",
     *     tags={"Airport"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="id Airport",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),    
     *     @OA\Response(response="200", description="Airport detail successfully"),
     * )
     */
    public function edit(Request $request)
    {
        try {
            $Airport = Airport::find($request->id);
            $Response = [];
            if($Airport)
            {
                $AirportData = [
                    "Name" => $Airport->name,
                ];
            }else{
                $AirportData = [
                    "data" => null
                ];
            }
            $Response[] = $AirportData;
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
     *      path="/api/admin/Airport/update",
     *      tags={"Airport"},
     *      summary="Update Airports",
     *      description="Store a Airports",
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="id Airport",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="Name Airport",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Airport Store successfully"),
     *     @OA\Response(response="409", description="Airport Validate Error"),
     *     @OA\Response(response="500", description="Server Error"),
     * )
     */
    public function update(Request $request)
    {
        try {
            $AirportRequest = new AirportRequest();
            $Validator = Validator::make($request->all(),$AirportRequest->rules());
            if ($Validator->fails()) {
                return Response::json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $Validator->errors()
                ], 409);
            }
            $Airport = Airport::find($request->id);
            $Airport->name = $request->name;
            $Airport->save();
            return Response::json([
                'status' => true,
                'message' => 'Done',
                'data' => $Airport
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
     *     path="/api/admin/Airport/destroy",
     *     summary="Delete a Airport",
     *     tags={"Airport"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="id Airport",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Airport detail successfully"),
     * )
     */
    public function destroy(Request $request)
    {
        try {
            $Airport = Airport::findOrfail($request->id);
            $Airport->delete();
            return Response::json([
                'status' => true,
                'data' => $Airport
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
     *     path="/api/admin/Airport/restore",
     *     summary="Restore a Airport",
     *     tags={"Airport"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="id Airport",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Airport detail successfully"),
     * )
     */
    public function restore(Request $request)
    {
        try {
            $Airport = Airport::where('id', $request->id)->restore();
            return Response::json([
                'status' => true,
                'data' => $Airport
            ], 200);
        } catch (\Throwable $th) {
            return Response::json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
