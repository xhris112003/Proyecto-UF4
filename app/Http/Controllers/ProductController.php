<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class ProductController extends Controller
{
    public function show($id)
    {
        $product = Http::get("http://api.tu-tienda.com/products/{$id}")->json();
        return view('product.show', compact('product'));
    }
}