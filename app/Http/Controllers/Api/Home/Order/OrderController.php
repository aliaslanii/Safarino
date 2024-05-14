<?php

namespace App\Http\Controllers\Api\Home\Order;

use App\Http\Controllers\Controller;
use App\Models\AirplaneTicket;
use App\Models\Order;
use App\Models\OrderInfo;
use App\Models\TrainTicket;
use App\Models\Transaction;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Response;

class OrderController extends Controller
{
    public function ticketCreate()
    {
        return view('FormPay');
    }
    /**
     * @OA\Get(
     *     path="/api/orders",
     *     summary="show a AirplaneTicket",
     *     tags={"Orders"},
     *     security={{"bearerAuth":{}}},  
     *     @OA\Response(response="200", description="AirplaneTicket detail successfully"),
     * )
     */
    public function orders(Request $request)
    {
        try {
            $Orders = $request->user()->Order;
            if ($Orders) {
                $Response = [];
                foreach ($Orders as $Order) {
                    $userPassengers = [];
                    if ($Order->type == "Airplane") {
                        $airplaneTicket = $Order->airplaneTicket;
                        $Ticket = [
                            "adultPrice" => number_format($airplaneTicket->adultPrice),
                            "arrivalTime" => $airplaneTicket->arrivalTime,
                            "arrivalDate" => verta($airplaneTicket->arrivalDate)->format('d-%B-l'),
                            "departureTime" => $airplaneTicket->departureTime,
                            "departureDate" => verta($airplaneTicket->departureDate)->format('d-%B-l'),
                            "maxAllowedBaggage" => $airplaneTicket->maxAllowedBaggage,
                            "aircraft" => $airplaneTicket->aircraft,
                            "capacity" => $airplaneTicket->capacity,
                            "flightNumber" => $airplaneTicket->flightNumber,
                            "origin" => $airplaneTicket->cityorigin->name,
                            "destination" => $airplaneTicket->citydestination->name,
                            'airport' => $airplaneTicket->airport->name,
                            'airline' => $airplaneTicket->airline->name,
                            'airline-photo' => $airplaneTicket->airline->profile_photo_path,
                            'type' => $airplaneTicket->type,
                            'cabinclass' => $airplaneTicket->cabinclass,
                            'isCompleted' => $airplaneTicket->isCompleted,
                        ];
                        foreach ($Order->airplaneTicket->passenger as $passenger) {
                            if ($passenger->user_id == $request->user()->id) {
                                $userPassengers[] = $passenger;
                            }
                        }
                    } elseif ($Order->type == "Train") {
                        $TrainTicket = $Order->trainTicket;
                        $Ticket = [
                            "adultPrice" => number_format($TrainTicket->adultPrice),
                            "arrivalTime" => $TrainTicket->arrivalTime,
                            "arrivalDate" => verta($TrainTicket->arrivalDate)->format('d-%B-l'),
                            "departureTime" => $TrainTicket->departureTime,
                            "departureDate" => verta($TrainTicket->departureDate)->format('d-%B-l'),
                            "capacity" => $TrainTicket->capacity,
                            "trainnumber" => $TrainTicket->trainnumber,
                            "origin" => $TrainTicket->cityorigin->name,
                            "destination" => $TrainTicket->citydestination->name,
                            'Railcompanie' => $TrainTicket->Railcompanie->name,
                            'Railcompanie-photo' => $TrainTicket->Railcompanie->profile_photo_path,
                            'type' => $TrainTicket->type,
                            'isCompleted' => $TrainTicket->isCompleted,
                        ];
                        foreach ($Order->trainTicket->passenger as $passenger) {
                            if ($passenger->user_id == $request->user()->id) {
                                $userPassengers[] = $passenger;
                            }
                        }
                    }
                    $AirplaneTicketData = [
                        'ordernumber' => $Order->ordernumber,
                        'Amount' => $Order->Amount,
                        'Status' => $Order->Status,
                        'type' => $Order->type,
                        'ticket' => $Ticket,
                        'passengers' => $userPassengers,
                    ];
                    $Response[] = $AirplaneTicketData;
                }
                return Response::json([
                    'status' => true,
                    'order' => $Response,
                ], 200);
            } else {
                return Response::json([
                    'status' => true,
                    'order' => null,
                ], 200);
            }
        } catch (\Throwable $th) {
            return Response::json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    public function payMent(Request $request)
    {
        try {
            // $ordernumber = random_int(1403, 99999999);
            // $order = new Order();
            // $order->user_id = 1;
            // // $order->user_id = $request->user()->id;
            // $order->mobile = "09227659746";
            // // $order->mobile = $request->user()->mobile;
            // $order->ordernumber = $ordernumber;
            // $order->Amount = $request->Amount;
            // $order->is_payed = 0;
            // $order->Status = "Expectation";
            // $order->type = $request->type;
            // if ($request->type == "Train") {
            //     $Ticket = TrainTicket::findOrfail($request->tickets_id);
            //     $Ticket->passenger()->syncWithoutDetaching($request->Passengers);
            //     $order->trainticket_id = $request->tickets_id;
            // } elseif ($request->type == "Airplane") {
            //     $Ticket = AirplaneTicket::findOrfail($request->tickets_id);
            //     $Ticket->passenger()->syncWithoutDetaching($request->Passengers);
            //     $order->airplanetickets_id = $Ticket->id;
            // }
            // $order->save();

            $url = 'https://sandbox.banktest.ir/saman/sep.shaparak.ir/OnlinePG/OnlinePG?';
            $data = [
                'Username' => "user134755515",
                "Password" => 52846752,
                "action" => "token",
                "Amount" => round(random_int(1000000, 99999999)),
                "Wage" => 2,
                "AffectiveAmount" => "134755516",
                "TerminalId" => 134755516,
                "ResNum" => random_int(1403, 99999999),
                "CellNumber" => "09227659746",
                "RedirectURL" => "http://localhost:8000/api/orders/Paydone"
            ];
            $response = Http::post($url, $data);
            if ($response->successful('https://sandbox.banktest.ir/saman/sep.shaparak.ir/OnlinePG/OnlinePG?')) {
                $jsonResponse = $response->json();
                $token = $jsonResponse['token'];
                return redirect('https://sandbox.banktest.ir/saman/sep.shaparak.ir/OnlinePG/SendToken?token='.$token);
            } else {
                return Response::json([
                    'status' => false,
                    'message' => 'Invalid request'
                ], 500);
            }
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
            if ($request->State == "OK") {
                $RefNum = OrderInfo::where('RefNum', $request->RefNum)->first();
                if ($RefNum) {
                    return Response::json([
                        'status' => false,
                        'message' => "Double Spending"
                    ], 500);
                } else {
                    $Transaction = new Transaction();
                    $Transaction->user_id = $request->user()->id;
                    $Transaction->transaction_type = "charge";
                    $Transaction->amount = $request->Amount;
                    $Transaction->description = "رسید دیجیتال : " . $request->RefNum;
                    $Transaction->save();
                    $wallet = $request->user()->wallet;
                    $wallet->inventory = $request->Amount;
                    $wallet->update();
                    $order = Order::where('ordernumber', $request->ResNum)->first();
                    if ($wallet->inventory >= $order->Amount) {
                        $Transaction = new Transaction();
                        $Transaction->user_id = $request->user()->id;
                        $Transaction->transaction_type = "debit";
                        $Transaction->amount = $order->Amount;
                        $Transaction->description = "سفارش .'$order->ordernumber'. - خرید بلیط: ";
                        $Transaction->save();
                        $wallet->inventory = $wallet->inventory - $request->Amount;
                        $wallet->update();
                        $order->Amount = $request->Amount;
                        $order->is_payed = 1;
                        $order->update();
                    }
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
            elseif ($request->State == "Failed") {
                return Response::json([
                    'status' => 2,
                    'message' => "Payment Failed"
                ], 500);
            }
            elseif ($request->State == "Canceled By User") {
                return Response::json([
                    'status' => 2,
                    'message' => "Canceled By User"
                ], 500);
            }
            elseif ($request->State == "Invalid Merchant") {
                return Response::json([
                    'status' => 2,
                    'message' => "Invalid Merchant"
                ], 500);
            }
            elseif ($request->State == "Invalid Merchant") {
                return Response::json([
                    'status' => 2,
                    'message' => "Invalid Merchant"
                ], 500);
            }
            if ($request->State == "InvalidParameters") {
                return Response::json([
                    'status' => 3,
                    'message' => "Invalid Parameters"
                ], 500);
            }
            if ($request->State == "Invalid Transaction") {
                return Response::json([
                    'status' => 12,
                    'message' => "Invalid Parameters"
                ], 500);
            }
            if ($request->State == "Honour With Identification") {
                return Response::json([
                    'status' => 8,
                    'message' => "Honour With Identification"
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
