<?php

namespace App\Http\Controllers\Api\Admin\Setting;

use App\Http\Controllers\Controller;
use App\Http\Requests\SettingRequest;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/admin/Setting/index",
     *     summary="index Setting",
     *     tags={"Setting"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response="200", description="Setting Show successfully"),
     * )
     */
    public function index()
    {
        try {
            $Setting = Setting::first();
            return Response::json([
                'status' => true,
                'data' => $Setting
            ]);
        } catch (\Throwable $th) {
            return Response::json([
                'status' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/admin/Setting/update",
     *     summary="Update Setting",
     *     tags={"Setting"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="first_phone",
     *         in="query",
     *         description="first_phone Site",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ), 
     *     @OA\Parameter(
     *         name="second_phone",
     *         in="query",
     *         description="second_phone Site",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="email",
     *         in="query",
     *         description="email Site",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="address",
     *         in="query",
     *         description="address Site",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="instagram",
     *         in="query",
     *         description="instagram Site",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="whatsapp",
     *         in="query",
     *         description="whatsapp Site",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="linkdin",
     *         in="query",
     *         description="linkdin Site",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="facebook",
     *         in="query",
     *         description="facebook Site",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Update Setting successfully"),
     * )
     */
    public function update(Request $request)
    {
        try {
            $SettingRequest = new SettingRequest();
            $Validator = Validator::make($request->all(),$SettingRequest->rules());
            if ($Validator->fails()) {
                return Response::json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $Validator->errors()
                ], 409);
            }
            $Setting = Setting::first();
            if ($Setting == null) {
                $Setting = new Setting();
            }
            $Setting->first_phone = $request->first_phone;
            $Setting->second_phone = $request->second_phone;
            $Setting->email = $request->email;
            $Setting->address = $request->address;
            $Setting->instagram = $request->instagram;
            $Setting->whatsapp = $request->whatsapp;
            $Setting->linkdin = $request->linkdin;
            $Setting->facebook = $request->facebook;
            $Setting->save();
            return Response::json([
                'status' => true,
                'data' => $Setting
            ]);
        } catch (\Throwable $th) {
            return Response::json([
                'status' => false,
                'message' => $th->getMessage()
            ]);
        }
    }
}
