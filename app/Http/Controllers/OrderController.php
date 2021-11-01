<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderRequestPayment;
use Illuminate\Support\Facades\Auth;
use Dnetix\Redirection\PlacetoPay;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Order $order, Request $request)
    {
        $reference = $request->reference;
        $order = Order::where('hash', $reference)->first();

        if ($order == false) {
            abort(404);
        }

        if (intval($order->user_id) !== intval($request->user()->id)) {
            abort(403);
        }

        $orderRequestPayment = OrderRequestPayment::where('order_id', $order->id)
            ->where('ending', 0)
            ->latest()
            ->first();
        $placetopay = $this->placetopay();

        $response = $placetopay->query($orderRequestPayment->request_id);        
        
        $order->status =  $response->status()->status();

        $status = $order->status;        
        
        $order->save();        
        
        $orders = Order::query()->where('user_id', auth()->user()->id);           

        $orders = $orders->get();

        $estado  = Order::where('status',  $status)->where('user_id', auth()->user()->id)->count();
        
        return view('orders.index', compact('orders', 'estado', 'status'));
    }



    public function show(Order $order)
    {
        $this->authorize('author', $order);
        $user = Auth::user();
        $reference = $order->hash;

        $item = json_decode($order->content);
        $envio = json_decode($order->envio);

        $placetopay = $this->placetopay();
        
        //dd($user,$placetopay,  $item);
        foreach($item as $i){

            $request = [
                'payment' => [
                    'reference' => $reference,
                    'description' => $i->name,
                    'amount' => [
                        'currency' => 'USD',
                        'total' => $i->price * $i->qty,
                    ],
                ],
                "buyer" => [
                    "name" => $user->name,                
                    "email" => $user->email,                    
                    "mobile" => $user->phone
                ],
                'expiration' => date('c', strtotime(' + 2 days')),
                'returnUrl' => route('orders.index') . '?reference=' . $reference,
                'ipAddress' => '127.0.0.1',
                'userAgent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36',
            ];
        }
        try {
            
            $response = $placetopay->request($request);
            //dd(response()->json($response->status()->message()),$response->processUrl(), $response->requestId());
                       
            if ($response->isSuccessful()) {
                // Redirect the client to the processUrl or display it on the JS extension
                $this->createRequestPayment($order->id, $response->requestId(), $response->processUrl());

                return response()->redirectTo($response->processUrl());
            } else {
                // There was some error so check the message
                return response()->json($response->status()->message());
            }
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }


   

    private function placetopay()
    {
        return new PlacetoPay([
            'login' => config('placetopay.login'), 
            'tranKey' => config('placetopay.trankey'), 
            'baseUrl' => config('placetopay.baseUrl'),
            'timeout' => 10, 
        ]);
    }
   

    protected function createRequestPayment($orderId, $requestId, $requestUrl)
    {
        return OrderRequestPayment::create([
            'order_id' => $orderId,
            'request_id' => $requestId,
            'process_url' => $requestUrl,
        ]);
    }

 
}
