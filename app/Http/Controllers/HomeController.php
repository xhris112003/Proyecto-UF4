<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $response = Http::withToken(env('API_TOKEN'))
            ->withOptions(['verify' => 'C:\Users\chris\OneDrive\Documents\Act-Servicios-web-con-Laravel\UF4\Proyecto-UF4\cacert.pem'])
            ->get('https://hardcore-heisenberg.217-76-159-75.plesk.page/api/products');
        $products = json_decode($response->body(), true)['data'];
        return view('home', compact('products'));
    }


}