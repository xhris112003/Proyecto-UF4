<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class ProductController extends Controller
{
    public function index()
    {
        $products = Http::get('https://hardcore-heisenberg.217-76-159-75.plesk.page/api/products')->json();
        return view('home', compact('products'));
    }
}