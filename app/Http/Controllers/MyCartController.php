<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MyCart;

class MyCartController extends Controller
{
    public function index()
    {
        $carts = MyCart::with(['user', 'product'])->get();
        return view('carts.index', compact('carts'));
    }
}