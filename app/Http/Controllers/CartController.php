<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class CartController extends Controller
{
    public function viewCart()
    {
        $cart = session()->get('cart', []);

        return view('view.cart', compact('cart'));
    }


    public function addToCart($productId)
    {
        // Obtener el producto de la API por su ID
        $response = Http::withToken(env('API_TOKEN'))
            ->withOptions(['verify' => 'C:\Users\chris\OneDrive\Documents\Act-Servicios-web-con-Laravel\UF4\Proyecto-UF4\cacert.pem'])
            ->get('https://hardcore-heisenberg.217-76-159-75.plesk.page/api/products/' . $productId);

        if ($response->failed()) {
            return response()->json(['success' => false, 'message' => 'Error al obtener el producto de la API.']);
        }



        $product = json_decode($response->body(), true)['data'];

        // Obtener el carrito de la sesión
        $cart = session()->get('cart', []);

        // Verificar si el producto ya está en el carrito
        if (isset($cart[$productId])) {
            // El producto ya está en el carrito, incrementar la cantidad
            $cart[$productId]['quantity']++;
        } else {
            // El producto no está en el carrito, agregarlo
            $cart[$productId] = [
                'id' => $product['id'],
                'name' => $product['name'],
                'price' => $product['price'],
                'quantity' => 1,
            ];
        }

        // Guardar el carrito en la sesión
        session()->put('cart', $cart);

        return response()->json(['success' => true]);
    }


    public function updateQuantity(Request $request)
    {
        $productId = $request->input('productId');
        $quantity = $request->input('quantity');

        // Obtener el carrito de la sesión
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            // Actualizar la cantidad del producto en el carrito
            $cart[$productId]['quantity'] = $quantity;
            // Guardar el carrito actualizado en la sesión
            session()->put('cart', $cart);
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'El producto no está en el carrito.']);
    }

    public function removeFromCart(Request $request)
    {
        $productId = $request->input('productId');

        // Obtener el carrito de la sesión
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            // Eliminar el producto del carrito
            unset($cart[$productId]);
            // Guardar el carrito actualizado en la sesión
            session()->put('cart', $cart);
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'El producto no está en el carrito.']);
    }


    public function checkout()
    {

        // Limpiar el carrito
        session()->forget('cart');

        return redirect()->route('viewCart')->with('success', '¡Compra realizada con éxito!');
    }



}