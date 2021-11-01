<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

use App\Models\Product;

class SearchController extends Controller
{
    public function __invoke(Request $request)
    {

        $name = $request->name;
        //buscador haciendo match con la tabla Product
        $products = Product::where('name', 'LIKE' ,'%' . $name . '%')
                                ->where('status', Order::PAYED)
                                ->paginate(8);

        return view('search', compact('products'));
    }
}
