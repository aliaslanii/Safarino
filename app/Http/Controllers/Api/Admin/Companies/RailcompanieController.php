<?php

namespace App\Http\Controllers\Api\Admin\Companies;

use App\helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\RailcompanieRequest;
use App\Models\Railcompanie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class RailcompanieController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/admin/Railcompanies/index",
     *     summary="index Railcompanies",
     *     tags={"Railcompanies"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response="200", description="Railcompanies Show successfully"),
     * )
     */
    public function index()
    {
        try {
            return Response::json([
                'status' => true,
                'Railcompanie' =>  Railcompanie::all()
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
     *     path="/api/admin/Railcompanies/create",
     *     summary="create Test Railcompanie Data",
     *     tags={"Railcompanies"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="Count",
     *         in="query",
     *         description="Count Test Data => Railcompanie",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ), 
     *     @OA\Response(response="200", description="Railcompanie create Test Data successfully"),
     * )
    */
    public function Create(Request $request)
    {
        try {
            $Railcompanie = Railcompanie::factory()->count($request->Count)->create();
            return Response::json([
                'status' => true,
                'Railcompanie' =>  $Railcompanie
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
     *      path="/api/admin/Railcompanies/store",
     *      tags={"Railcompanies"},
     *      summary="Store Railcompanies",
     *      description="Store a Railcompanies",
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="Name Railcompanie",
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
     *                      description="image Railcompanie",
     *                      type="string",
     *                      format="binary"
     *                  ),
     *              ),
     *          ),
     *      ),
     *     @OA\Response(response="200", description="Railcompanie Store successfully"),
     *     @OA\Response(response="409", description="Railcompanie Validate Error"),
     *     @OA\Response(response="500", description="Server Error"),
     * )
     */
    public function store(Request $request)
    {
        try {
            $RailcompanieRequest = new RailcompanieRequest();
            $Validator = Validator::make($request->all(),$RailcompanieRequest->rules());
            if ($Validator->fails()) {
                return Response::json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $Validator->errors()
                ], 409);
            }
            $path = 'images/Railcompanie';
            $helper = new helper();
            $image = $helper->moveFile($request,$path);
            $Railcompanie = new Railcompanie();
            $Railcompanie->name = $request->name;
            $Railcompanie->profile_photo_path = $image;
            $Railcompanie->save();
            return Response::json([
                'status' => true,
                'image' => $Railcompanie
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
     *     path="/api/admin/Railcompanies/show",
     *     summary="show a Railcompanie",
     *     tags={"Railcompanies"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="id Railcompanie",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),    
     *     @OA\Response(response="200", description="Railcompanie detail successfully"),
     * )
     */
    public function show(Request $request)
    {
        try {
            $Railcompanie = Railcompanie::find($request->id);
            $Response = [];
            if($Railcompanie)
            {
                $RailcompanieData = [
                    "Name" => $Railcompanie->name,
                    "Photo" => $Railcompanie->profile_photo_path,
                ];
            }else{
                $RailcompanieData = [
                    "data" => null
                ];
            }
            $Response[] = $RailcompanieData;
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
     *     path="/api/admin/Railcompanies/edit",
     *     summary="edit a Railcompanie",
     *     tags={"Railcompanies"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="id Railcompanie",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),    
     *     @OA\Response(response="200", description="Railcompanie detail successfully"),
     * )
     */
    public function edit(Request $request)
    {
        try {
            $Railcompanie = Railcompanie::find($request->id);
            $Response = [];
            if($Railcompanie)
            {
                $RailcompanieData = [
                    "Name" => $Railcompanie->name,
                    "Photo" => $Railcompanie->profile_photo_path,
                ];
            }else{
                $RailcompanieData = [
                    "data" => null
                ];
            }
            $Response[] = $RailcompanieData;
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
     *      path="/api/admin/Railcompanies/update",
     *      tags={"Railcompanies"},
     *      summary="Update Railcompanies",
     *      description="Store a Railcompanies",
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="Name Railcompanie",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="Name Railcompanie",
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
     *                      description="image Railcompanie",
     *                      type="string",
     *                      format="binary"
     *                  ),
     *              ),
     *          ),
     *      ),
     *     @OA\Response(response="200", description="Railcompanie Store successfully"),
     *     @OA\Response(response="409", description="Railcompanie Validate Error"),
     *     @OA\Response(response="500", description="Server Error"),
     * )
     */
    public function update(Request $request)
    {
        try {
            $RailcompanieRequest = new RailcompanieRequest();
            $Validator = Validator::make($request->all(),$RailcompanieRequest->rulesUpdate($request->id));
            if ($Validator->fails()) {
                return Response::json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $Validator->errors()
                ], 409);
            }
            $path = 'images/Railcompanie';
            $helper = new helper();
            $Railcompanie = Railcompanie::find($request->id);
            $image = $helper->updateFile($Railcompanie,$request,$path);
            $Railcompanie->name = $request->name;
            $Railcompanie->profile_photo_path = $image;
            $Railcompanie->save();
            return Response::json([
                'status' => true,
                'message' => 'Done',
                'data' => $Railcompanie
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
     *     path="/api/admin/Railcompanies/destroy",
     *     summary="Delete a Railcompanie",
     *     tags={"Railcompanies"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="id Railcompanie",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Railcompanie detail successfully"),
     * )
     */
    public function destroy(Request $request)
    {
        try {
            $Railcompanie = Railcompanie::findOrfail($request->id);
            $Railcompanie->delete();
            return Response::json([
                'status' => true,
                'data' => $Railcompanie
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
     *     path="/api/admin/Railcompanies/restore",
     *     summary="Restore a Railcompanie",
     *     tags={"Railcompanies"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="id Railcompanie",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Railcompanie detail successfully"),
     * )
     */
    public function restore(Request $request)
    {
        try {
            $Railcompanie = Railcompanie::where('id', $request->id)->restore();
            return Response::json([
                'status' => true,
                'data' => $Railcompanie
            ], 200);
        } catch (\Throwable $th) {
            return Response::json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
