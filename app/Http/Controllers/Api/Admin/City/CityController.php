<?php

namespace App\Http\Controllers\Api\Admin\City;

use App\Http\Controllers\Controller;
use App\Http\Requests\CityRequest;
use App\Models\City;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class CityController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/admin/City/index",
     *     summary="All City",
     *     tags={"City"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response="200", description="City detail successfully"),
     * )
    */
    public function index()
    {
        try {
            return Response::json([
                'status' => true,
                'City' =>  City::all()
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
     *     path="/api/admin/City/store",
     *     summary="Create a City",
     *     tags={"City"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="city",
     *         in="query",
     *         description="Name City",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),    
     *     @OA\Response(response="200", description="City detail successfully"),
     * )
     */
    public function store(Request $request)
    {
        try {
            $CityRequest = new CityRequest();
            $Validator = Validator::make($request->all(), $CityRequest->rules(), $CityRequest->messages());
            if ($Validator->fails()) {
                return Response::json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $Validator->errors()
                ], 409);
            }
            $City = new City();
            $City->city = $request->city;
            $City->save();
            return Response::json([
                'status' => true,
                'message' => 'Done',
                'data' => $City
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
     *     path="/api/admin/City/show",
     *     summary="show a City",
     *     tags={"City"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="id City",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),    
     *     @OA\Response(response="200", description="City detail successfully"),
     * )
     */
    public function show(Request $request)
    {
        try {
            $City = City::findOrfail($request->id);
            return Response::json([
                'status' => true,
                'data' => $City
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
     *     path="/api/admin/City/edit",
     *     summary="edit a City",
     *     tags={"City"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="id City",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),    
     *     @OA\Response(response="200", description="City detail successfully"),
     * )
     */
    public function edit(Request $request)
    {
        try {
            $City = City::findOrfail($request->id);
            return Response::json([
                'status' => true,
                'data' => $City
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
     *     path="/api/admin/City/update",
     *     summary="Update a City",
     *     tags={"City"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="id City",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),    
     *     @OA\Parameter(
     *         name="city",
     *         in="query",
     *         description="Name City",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ), 
     *     @OA\Response(response="200", description="City detail successfully"),
     * )
     */
    public function update(Request $request)
    {
        try {
            $City = City::findOrfail($request->id);
            $City->city = $request->city;
            $City->save();
            return Response::json([
                'status' => true,
                'data' => $City
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
     *     path="/api/admin/City/destroy",
     *     summary="Delete a City",
     *     tags={"City"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="id City",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="City detail successfully"),
     * )
     */
    public function destroy(Request $request)
    {
        try {
            $City = City::findOrfail($request->id);
            $City->delete();
            return Response::json([
                'status' => true,
                'data' => $City
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
     *     path="/api/admin/City/restore",
     *     summary="Restore a City",
     *     tags={"City"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="id City",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="City detail successfully"),
     * )
     */
    public function restore(Request $request)
    {
        try {
            $City = City::where('id', $request->id)->restore();
            return Response::json([
                'status' => true,
                'data' => $City
            ], 200);
        } catch (\Throwable $th) {
            return Response::json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
