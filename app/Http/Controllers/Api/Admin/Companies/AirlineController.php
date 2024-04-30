<?php

namespace App\Http\Controllers\Api\Admin\Companies;

use App\helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\AirlineRequest;
use App\Models\Airline;
use App\Models\Airlines;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class AirlineController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/admin/Airline/index",
     *     summary="index Airline",
     *     tags={"Airline"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response="200", description="Airline Show successfully"),
     * )
     */
    public function index()
    {
        try {
            return Response::json([
                'status' => true,
                'Airline' =>  Airline::all()
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
     *     path="/api/admin/Airline/create",
     *     summary="create Test Airline Data",
     *     tags={"Airline"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="Count",
     *         in="query",
     *         description="Count Test Data => Airline",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ), 
     *     @OA\Response(response="500", description="Server Error"),
     *     @OA\Response(response="200", description="Airline create Test Data successfully"),
     * )
    */
    public function create(Request $request)
    { 
        try {
            $Airline = Airline::factory()->count($request->Count)->create();
            return Response::json([
                'status' => true,
                'Airline' =>  $Airline
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
     *      path="/api/admin/Airline/store",
     *      tags={"Airline"},
     *      summary="Store Airline",
     *      description="Store a Airline",
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="Name Airline",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *      @OA\RequestBody(
     *          required=true,
     *          description="Image file to upload",
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="image",
     *                      description="image Airline",
     *                      type="string",
     *                      format="binary"
     *                  ),
     *              ),
     *          ),
     *      ),
     *     @OA\Response(response="200", description="Airline Store successfully"),
     *     @OA\Response(response="409", description="Airline Validate Error"),
     *     @OA\Response(response="500", description="Server Error"),
     * )
     */
    public function store(Request $request)
    {
        try {
            $AirlineRequest = new AirlineRequest();
            $Validator = Validator::make($request->all(),$AirlineRequest->rules());
            if ($Validator->fails()) {
                return Response::json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $Validator->errors()
                ], 409);
            }
            $path = 'images/Airline';
            $helper = new helper();
            $image = $helper->moveFile($request,$path);
            $Airline = new Airline();
            $Airline->name = $request->name;
            $Airline->profile_photo_path = $image;
            $Airline->save();
            return Response::json([
                'status' => true,
                'image' => $Airline
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
     *     path="/api/admin/Airline/show",
     *     summary="show a Airline",
     *     tags={"Airline"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="id Airline",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),    
     *     @OA\Response(response="200", description="Airline detail successfully"),
     * )
     */
    public function show(Request $request)
    {
        try {
            $Airline = Airline::find($request->id);
            $Response = [];
            if($Airline)
            {
                $AirlineData = [
                    "Name" => $Airline->name,
                    "Photo" => $Airline->profile_photo_path,
                ];
            }else{
                $AirlineData = [
                    "data" => null
                ];
            }
            $Response[] = $AirlineData;
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
     *     path="/api/admin/Airline/edit",
     *     summary="edit a Airline",
     *     tags={"Airline"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="id Airline",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),    
     *     @OA\Response(response="200", description="Airline detail successfully"),
     * )
     */
    public function edit(Request $request)
    {
        try {
            $Airline = Airline::find($request->id);
            $Response = [];
            if($Airline)
            {
                $AirlineData = [
                    "Name" => $Airline->name,
                    "Photo" => $Airline->profile_photo_path,
                ];
            }else{
                $AirlineData = [
                    "data" => null
                ];
            }
            $Response[] = $AirlineData;
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
     *      path="/api/admin/Airline/update",
     *      tags={"Airline"},
     *      summary="Update Airlines",
     *      description="Store a Airlines",
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="Name Airline",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="Name Airline",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *          required=true,
     *          description="Image file to upload",
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="image",
     *                      description="image Airline",
     *                      type="string",
     *                      format="binary"
     *                  ),
     *              ),
     *          ),
     *      ),
     *     @OA\Response(response="200", description="Airline Store successfully"),
     *     @OA\Response(response="409", description="Airline Validate Error"),
     *     @OA\Response(response="500", description="Server Error"),
     * )
     */
    public function update(Request $request)
    {
        try {
            $AirlineRequest = new AirlineRequest();
            $Validator = Validator::make($request->all(),$AirlineRequest->rulesUpdate($request->id));
            if ($Validator->fails()) {
                return Response::json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $Validator->errors()
                ], 409);
            }
            $path = 'images/Airline';
            $helper = new helper();
            $Airline = Airline::find($request->id);
            $image = $helper->updateFile($Airline,$request,$path);
            $Airline->name = $request->name;
            $Airline->profile_photo_path = $image;
            $Airline->save();
            return Response::json([
                'status' => true,
                'message' => 'Done',
                'data' => $Airline
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
     *     path="/api/admin/Airline/destroy",
     *     summary="Delete a Airline",
     *     tags={"Airline"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="id Airline",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Airline detail successfully"),
     * )
     */
    public function destroy(Request $request)
    {
        try {
            $Airline = Airline::findOrfail($request->id);
            $Airline->delete();
            return Response::json([
                'status' => true,
                'data' => $Airline
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
     *     path="/api/admin/Airline/restore",
     *     summary="Restore a Airline",
     *     tags={"Airline"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="id Airline",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Airline detail successfully"),
     * )
     */
    public function restore(Request $request)
    {
        try {
            $Airline = Airline::where('id', $request->id)->restore();
            return Response::json([
                'status' => true,
                'data' => $Airline
            ], 200);
        } catch (\Throwable $th) {
            return Response::json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}