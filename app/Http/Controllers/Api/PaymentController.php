<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Payment;

class PaymentController extends Controller
{
    public function storepayment(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'order_id' => 'required',
                'order_amount' => 'required',
                'referance_id' => 'required',
                'tx_status' => 'required',
                'txMsg' => 'required',
                'txTime' => 'required',
                'paymentmode'=>'required',
                'signature' => 'required',
                'status' => 'required'

            ]);
            if ($validator->fails()) {
                return response()->json(['status' => false, "message" => "error", "error" => $validator->errors(), 'data' => []], 200);
            }
            $payment = new Payment;
            $payment->order_id = $request->order_id;
            $payment->orderAmount = $request->order_amount;
            $payment->referenceId = $request->referance_id;
            $payment->txStatus = $request->tx_status;
            $payment->paymentMode=$request->paymentmode;
            $payment->txMsg = $request->txMsg;
            $payment->txTime = $request->txTime;
            $payment->signature = $request->signature;
            $payment->status = $request->status;
            $payment->user_id = \Auth::user()->id;
            $payment->save();
            return response()->json(['status' => true, "message" => "Payment done Successfully", "error" =>[], 'data' =>$payment], 200);

        } catch (\Exception $ex) {
            return response()->json(['status' => false, "message" => $ex->getMessage(), "error" => ['error'], 'data' => []], 200);
        }
    }
}
