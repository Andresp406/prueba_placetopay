<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Order;

class WelcomeController extends Controller
{
    public function __invoke()
    {
        //generacion del mensaje flash para el banner que nos indica
        //las ordenes pendientes y por medio de las tareas automatizadas o schedules
        //eliminamos las ordenes.

        //este banner se ejecuta si y solo si el usuario se encuentra autenticado
        if (auth()->user()) {

            $pendiente = Order::where('status', 1)->where('user_id', auth()->user()->id)->count();

            if ($pendiente) {

                $mensaje = "Usted tiene $pendiente ordenes pendientes. <a class='font-bold' href='" . route('orders.index') ."?status=1'>Ir a pagar</a>";

                session()->flash('flash.banner', $mensaje);
            }

        }

        $categories = Category::all();

        return view('welcome', compact('categories'));
    }
}
