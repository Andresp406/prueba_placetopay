<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;

    //creo una policy para que otros usuarios no vean pedidos de otros usuarios 
    //y con esto controlamos la informacion de nuestra aplicacion implementando politicas
    public function author(User $user, Order $order){
        return true;
      /*   if ($order->user_id == auth()->id()) {
            return true;
        }else{
            return false;
        } */
    }

    public function payment(User $user, Order $order){
      return true;
        /*   if ($order->status == 2) {
            return true;
        }else{
            return false;
        } */
    }
}
