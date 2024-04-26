<?php

namespace App\Http\Controllers\Api\Home\Wallet;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class WalletController extends Controller
{
    public function chargewallet(Request $request)
    {
        try {
            $walet = Auth::user()->wallet;
            $walet->inventory += $request->numeric;
            $walet->update();
            return Response::json([
                'wallet' => $walet
            ]);
        } catch (\Throwable $th) {
            return Response::json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
