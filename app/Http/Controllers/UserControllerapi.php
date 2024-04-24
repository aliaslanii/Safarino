<?php

namespace App\Http\Controllers;

use App\Http\Requests\BankInformationRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\PersonalInformationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class UserControllerapi extends Controller
{
    /**
     * @OA\Put(
     *     path="/api/User/ChangePassword",
     *     summary="ChangePassword a User",
     *     security={{"bearerAuth":{}}},
     *     tags={"User"},
     *      @OA\Parameter(
     *         name="now_password",
     *         in="query",
     *         description="User Now password",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *    @OA\Parameter(
     *         name="new_password",
     *         in="query",
     *         description="User New password",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="new_password_confirmation",
     *         in="query",
     *         description="User New password confirmation",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="User update successfully"),
     * )
     */
    public function changePassword(Request $request)
    {
        try {
            $user = $request->user();
            $ChangePasswordRequest = new ChangePasswordRequest();
            $Validate = Validator::make($request->all(), $ChangePasswordRequest->rules());
            if ($Validate->fails()) {
                return Response::json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $Validate->errors()
                ], 403);
            }
            if (Hash::check($request->now_password, $user->password)) {
                $user->password = Hash::make($request->new_password);
                $user->save();
                $user->tokens()->delete();
                return Response::json([
                    'status' => true,
                    'message' => 'changed Password successfully',
                ], 200);
            } else {
                return Response::json([
                    'status' => true,
                    'message' => 'The current password is not correct',
                ], 500);
            }
        } catch (\Throwable $th) {
            return Response::json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    /**
     * @OA\Put(
     *    path="/api/User/PersonalInformation",
     *    summary="show a User",
     *    tags={"User"},
     *    security={{"bearerAuth":{}}},
     *    @OA\Parameter(
     *         name="firstName",
     *         in="query",
     *         description="firstName Passenger",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),    
     *     @OA\Parameter(
     *         name="lastName",
     *         in="query",
     *         description="lastName Passenger",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),  
     *     @OA\Parameter(
     *         name="nationalcode",
     *         in="query",
     *         description="nationalcode Passenger",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),    
     *     @OA\Parameter(
     *         name="gender",
     *         in="query",
     *         description="gender Passenger (male,femail)",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ), 
     *     @OA\Parameter(
     *         name="birthday",
     *         in="query",
     *         description="birthday Passenger",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ), 
     *     @OA\Response(response="200", description="Passenger detail successfully"),
     *     @OA\Response(response="409", description="TrainTicket Validate Error"), 
     *     @OA\Response(response="500", description="Server Error"),
     * )
     */
    public function personalInformation(Request $request)
    {
        try {
            $PersonalInformationRequest = new PersonalInformationRequest();
            $Validate = Validator::make($request->all(), $PersonalInformationRequest->rules());
            if ($Validate->fails()) {
                return Response::json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $Validate->errors()
                ], 403);
            }
            $user = $request->user();
            $user->firstName = $request->firstName;
            $user->lastName = $request->lastName;
            $user->birthday = $request->birthday;
            $user->nationalcode = $request->nationalcode;
            $user->gender = $request->gender;
            $user->update();
            return Response::json([
                'status' => true,
                'message' => 'User Created Personal Information Successfully',
                'token' => $user
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
     *     path="/api/User/BankInformation",
     *     summary="Add bankInformation a User",
     *     security={{"bearerAuth":{}}},
     *     tags={"User"},
     *      @OA\Parameter(
     *         name="shabanumber",
     *         in="query",
     *         description="User shabanumber",
     *         @OA\Schema(type="string")
     *     ),
     *    @OA\Parameter(
     *         name="cardnumber",
     *         in="query",
     *         description="User cardnumber",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="add personalInformation successfully"),
     * )
     */
    public function bankInformation(Request $request)
    {
        try {
            $user = $request->user();
            $BankInformationRequest = new BankInformationRequest();
            $Validate = Validator::make($request->all(), $BankInformationRequest->rules());
            if ($Validate->fails()) {
                return Response::json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $Validate->errors()
                ], 403);
            }
            $user = $request->user();
            $user->shabanumber = $request->shabanumber;
            $user->cardnumber = $request->cardnumber;
            $user->update();
            return Response::json([
                'status' => true,
                'message' => 'User Created Bank Information Successfully',
                'token' => $user
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
     *     path="/api/User/ChangeMobile",
     *     summary="Add mobile a User",
     *     security={{"bearerAuth":{}}},
     *     tags={"User"},
     *      @OA\Parameter(
     *         name="mobile",
     *         in="query",
     *         description="User mobile",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="add personalInformation successfully"),
     * )
     */
    public function changeMobile(Request $request)
    {
        try {
            $user = $request->user();
            $Validate = Validator::make($request->all(),[
                'mobile' => "required|min:11|max:11|unique:users,mobile"
            ]);
            if ($Validate->fails()) {
                return Response::json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $Validate->errors()
                ], 403);
            }
            $user = $request->user();
            $user->mobile = $request->mobile;
            $user->update();
            return Response::json([
                'status' => true,
                'message' => 'User Change Mobile Successfully',
                'token' => $user
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
     *     path="/api/User/ChangeEmail",
     *     summary="Add email a User",
     *     security={{"bearerAuth":{}}},
     *     tags={"User"},
     *      @OA\Parameter(
     *         name="email",
     *         in="query",
     *         description="email mobile",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="add personalInformation successfully"),
     * )
     */
    public function changeEmail(Request $request)
    {
        try {
            $user = $request->user();
            $Validate = Validator::make($request->all(),[
                'email' => "required|email|unique:users,email"
            ]);
            if ($Validate->fails()) {
                return Response::json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $Validate->errors()
                ], 403);
            }
            $user = $request->user();
            $user->email = $request->email;
            $user->update();
            return Response::json([
                'status' => true,
                'message' => 'User Change Email Successfully',
                'token' => $user
            ], 200);
        } catch (\Throwable $th) {
            return Response::json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
