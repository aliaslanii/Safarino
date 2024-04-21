<?php

namespace App\Http\Controllers\Api\Order;

use App\Http\Controllers\Controller;
use App\Models\AirplaneTicket;
use App\Models\Order;
use App\Models\OrderInfo;
use App\Models\TrainTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

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
    public function payDone(Request $request)
    {
        try {
            if($request->State == "OK")
            {
                $RefNum = OrderInfo::where('RefNum',$request->RefNum)->first();
                if($RefNum)
                {
                    return Response::json([
                        'status' => false,
                        'message' => "Double Spending"
                    ], 500); 
                }else
                {
                    $order = Order::where('ordernumber',$request->ResNum)->first();
                    $order->Amount = $request->Amount;
                    $order->is_payed = 1;
                    $order->update();
                    $orderinfo = new OrderInfo();
                    $orderinfo->order_id = $order->id;
                    $orderinfo->MID = $request->MID;
                    $orderinfo->State = $request->State;
                    $orderinfo->Status = $request->StateCode;
                    $orderinfo->RRN = $request->RRN;
                    $orderinfo->ResNum = $request->ResNum;
                    $orderinfo->RefNum = $request->RefNum;
                    $orderinfo->SecurePan = $request->SecurePan;
                    $orderinfo->Amount = $request->Amount;
                    $orderinfo->Wage = $request->Wage;
                    $orderinfo->CID = $request->CID;
                    $orderinfo->save();
                    return Response::json([
                        'status' => true,
                        'data' => $order
                    ], 200);
                }
            }
            if($request->State == "Failed")
            {
                return Response::json([
                    'status' => false,
                    'message' => "Payment Failed"
                ], 500);
            } 
            if($request->State == "InvalidParameters")
            {
                return Response::json([
                    'status' => false,
                    'message' => "Invalid Parameters"
                ], 500);
            }
        } catch (\Throwable $th) {
            return Response::json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
