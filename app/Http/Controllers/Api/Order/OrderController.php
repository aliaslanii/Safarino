<?php

namespace App\Http\Controllers\Api\Order;

use App\Http\Controllers\Controller;
use App\Models\AirplaneTicket;
use App\Models\Order;
use App\Models\TrainTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    public function ticketCreate()
    {
        return view('FormPay');
    }
    public function payMent(Request $request)
    {
        try {
            $ordernumber = random_int(1403, 99999999);
            $order = new Order();
            $order->user_id = 1;
            // $order->user_id = $request->user()->id;
            $order->mobile = "09227659746";
            // $order->mobile = $request->user()->mobile;
            $order->ordernumber = $ordernumber;
            $order->Amount = $request->Amount;
            $order->is_payed = 0;
            $order->Status = "Expectation";
            $order->type = $request->type;
            if ($request->type == "Train") {
                $Ticket = TrainTicket::findOrfail($request->tickets_id);
                $Ticket->passenger()->syncWithoutDetaching($request->Passengers);
                $order->trainticket_id = $request->tickets_id;
            } elseif ($request->type == "Airplane") {
                $Ticket = AirplaneTicket::findOrfail($request->tickets_id);
                $Ticket->passenger()->syncWithoutDetaching($request->Passengers);
                $order->airplanetickets_id = $Ticket->id;
            }
            $order->save();
            $data = [
                'Username' => "user134755515",
                "Password" => 52846752,
                "Amount" => $request->Amount,
                "Wage" => 2,
                "AffectiveAmount" => "134755516",
                "TerminalId" => 134755516,
                "ResNum" => $ordernumber,
                "CellNumber" => $request->CellNumber,
                "RedirectURL" => "http://localhost:8000/api/order/Paydone"
            ];
            return redirect()->to('https://sandbox.banktest.ir/saman/sep.shaparak.ir/payment.aspx?' . http_build_query($data));
        } catch (\Throwable $th) {
            return Response::json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    /**
     * @OA\Post(
     *     path="/api/order/Paydone",
     *     summary="detail TrainTicket",
     *     tags={"Order"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="Airplane",
     *         in="query",
     *         description="id AirplaneTicket",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),   
     *     @OA\Parameter(
     *         name="totalPrice",
     *         in="query",
     *         description="totalPrice Ticket",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="type",
     *         in="query",
     *         description="type Ticket",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),   
     *     @OA\Parameter(
     *         name="passenger",
     *         in="query",
     *         description="passenger Ticket",
     *         required=true,
     *         @OA\Schema(type="json")
     *     ), 
     *     @OA\Property(property="languages", type="array", @OA\Items(type="string")),
     *     @OA\Response(response="200", description="Order Create successfully"),
     * )
     */
    public function payDone(Request $request)
    {
        try {
            if($request->State == "OK")
            {
                $order = Order::where('ordernumber',$request->ResNum)->first();
                $order->is_payed = 1;
                $order->update();
                return $order;
            }
        } catch (\Throwable $th) {
            return Response::json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
