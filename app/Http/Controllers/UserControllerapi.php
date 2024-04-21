<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UpdateUserReauest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class UserControllerapi extends Controller
{

    /**
     * @OA\Get(
     *     path="/api/User/show",
     *     summary="show a User",
     *     tags={"User"},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="id User",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="User detail successfully"),
     * )
     */
    public function show(Request $request)
    {
        try {
            $User = User::findOrfail($request->id);
            return Response::json([
                'status' => true,
                'data' => $User
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
     *     path="/api/User/update",
     *     summary="show a User",
     *     tags={"User"},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="id User",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="id User",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ), 
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="id User",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="id User",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="User update successfully"),
     * )
     */
    // public function update(Request $request)
    // {
    //     try {
    //         // $UpdateUserReauest = new UpdateUserReauest();
    //         // $Validate = Validator::make($request->all(), $UpdateUserReauest->rules());
    //         if ($Validate->fails()) {
    //             return Response::json([
    //                 'status' => false,
    //                 'message' => 'validation error',
    //                 'errors' => $Validate->errors()
    //             ], 403);
    //         }
    //         $user = $request->user();
    //         $user->$request->name;
    //         $user->$request->mobile;
    //         $user->$request->email;
    //         $user->update();
    //         return Response::json([
    //             'status' => true,
    //             'message' => 'User Created Successfully',
    //             'token' => $user
    //         ], 200);
    //     } catch (\Throwable $th) {
    //         return Response::json([
    //             'status' => false,
    //             'message' => $th->getMessage()
    //         ], 500);
    //     }
    // }
   /**
     * @OA\Delete(
     *     path="/api/User/destroy",
     *     summary="Delete a User",
     *     tags={"User"},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="id User",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="User Delete successfully"),
     * )
     */
    public function destroy(Request $request)
    {
        try {
            $User = User::findOrfail($request->id);
            $User->delete();
            return Response::json([
                'status' => true,
                'data' => $User
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
     *     path="/api/User/restore",
     *     summary="restore a User",
     *     tags={"User"},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="id User",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="User restore successfully"),
     * )
     */
    public function restore(Request $request)
    {
        try {
            $User = User::where('id',$request->id)->restore();
            return Response::json([
                'status' => true,
                'data' => $User
            ], 200);
        } catch (\Throwable $th) {
            return Response::json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
       
    }
}
