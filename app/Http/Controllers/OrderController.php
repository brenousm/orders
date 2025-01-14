<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderCancelRequest;
use App\Http\Requests\OrderCreateRequest;
use App\Http\Requests\OrderNotifyRequest;
use App\Http\Requests\OrderUpdateRequest;
use App\Http\Resources\OrderResource;
use App\Mail\SendEmail;
use App\Models\Order;
use App\Models\Status;
use App\Traits\HandleMessages;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Auth;

/**
 * Class to manage orders
 */
class OrderController extends Controller
{
    use HandleMessages;
    /**
        * Display a listing of the orders.
        *
        * @return Response
        */
        public function index(Request $request)
        {
            try {
                $orders = Order::where('user_id',Auth::id());
                //filter by destination
                if($request->has('destination')){
                    $orders = $orders->where("destination","like","%$request->destination%");
                }
    
                //filter by create data
                if($request->has('create')){
                    try {
                        $validDate = Carbon::createFromDate($request->create);
                    } catch (\Throwable $th) {
                        return self::defaultJsonReturn(422,'validation.invalid_date');
                    }  
    
                    $orders = $orders->whereDate("created_at",$validDate);
                }
    
                //filter by date inside travel periodo
                if($request->has('travel')){
                    try {
                            $minDate = Carbon::createFromDate($request->travel)->subDay();
                            $maxDate = Carbon::createFromDate($request->travel)->addDay();
                            //dd($minDate,$maxDate);
                    } catch (\Throwable $th) {
                        return self::defaultJsonReturn(422,'validation.invalid_date');
                    }  
                     
                    $orders = $orders->whereBetween("departure",[$minDate,$maxDate])
                                    ->orWhereBetween("arrival",[$minDate,$maxDate]);
                  }
    
                $orders = $orders->get();
                return new OrderResource($orders);
    
            } catch (\Throwable $th) {
                return self::handleErrors($th);
            }
        }
    
    
        /**
            * Store a newly created order in storage.
            *
            * @return Response
            */
        public function store(OrderCreateRequest $request)
        {
            try {
                $user = Auth::user();
                $newOrder = Order::create(
                    [
                        "requester_name"=>$request->requester_name,
                        "destination"=> $request->destination,
                        "departure"=>$request->departure,
                        "arrival"=>$request->arrival,
                        "user_id"=> $user->id,
                        "status_id"=> $request->status
                    ]
                );
                return new OrderResource($newOrder);
            } catch (\Throwable $th) {
                return self::handleErrors($th);
            }
        }
    
        /**
            * Display the specified order.
            *
            * @param  int  $id
            * @return Response
            */
        public function show($id)
        {
            try {
                $order = Order::where('user_id',Auth::id())->where('id',$id)->first();
                return new OrderResource($order);
            } catch (\Throwable $th) {
                return self::handleErrors($th);
            }
        }
    

        public function cancelOrder(OrderCancelRequest $request){
            try {
                $order = Order::where('id',$request->id)->first();

                    if($order->user_id != Auth::id()){
                        return self::defaultJsonReturn(401,'messages.order_not_owner');
                    }

                    if($order->status->id != Status::APROVADO){
                        return self::defaultJsonReturn(412,'messages.order_cannot_remove');
                    }
        
                    $order->status_id = Status::CANCELADO;
                    $order->save();
        
                    return self::defaultJsonReturn(200,'messages.order_canceled_success',["id"=>$order->id]);

            } catch (\Throwable $th) {
                return self::handleErrors($th);
            }
        }
    
        /**
            * Update the status of specified order in storage.
            *
            * @param  int  $id
            * @return Response
            */
        public function updateStatus(OrderUpdateRequest $request)
        {
            try {
                $order = Order::where('id',$request->id)->first();

                if($order->user_id != Auth::id()){
                    return self::defaultJsonReturn(401,'messages.order_not_owner');

                }

                $order->update(['status_id'=>$request->status]);

                return new OrderResource($order);
            } catch (\Throwable $th) {
                return self::handleErrors($th);
            }

        }

        /**
            * Update the status of specified order in storage.
            *
            * @param  int  $id
            * @return Response
            */
            public function notifyRequester(OrderNotifyRequest $request)
            {
                try {

                    $order = Order::where('id',$request->id)->first();

                    if($order->user_id != Auth::id()){
                        return self::defaultJsonReturn(401,'messages.order_not_owner');
                    }

                    $requester = $order->user;
                    $message = $request->message;
    
                    //Send email for requester
                    $params = [
                        "name" =>$requester->name ,
                        "order" => $order->id,
                        "message" =>$request->message ,
                    ];
    
                    $destinations = [$requester->email];
    
                    $email = new SendEmail("Alteração no status do seu pedido. ",$destinations,'emails.notify_order',$params);
                    $email->sendMail();
                    //end of send email
                    return self::defaultJsonReturn(200,'messages.user_notify_success',["id"=>$order->id]);
                } catch (\Throwable $th) {
                    return self::handleErrors($th);
                }
            }
}
