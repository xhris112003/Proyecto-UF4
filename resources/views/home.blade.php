@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Productos
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @foreach ($products as $product)
                        <div class="row">
                            <div class="card mx-auto">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $product['name'] }}</h5>
                                    <p class="card-text">{{ $product['description'] }}</p>
                                    <p class="card-text">Precio: {{ $product['price'] }}</p>
                                    <button class="btn btn-primary addToCartButton"
                                        data-product-id="{{ $product['id'] }}">Agregar al carrito</button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const addToCartButtons = document.querySelectorAll(".addToCartButton");
        addToCartButtons.forEach(button => {
            button.addEventListener("click", function() {
                const productId = button.getAttribute("data-product-id");
                const addToCartUrl = "{{ route('cart.add', ['productId' => ':productId']) }}";
                const url = addToCartUrl.replace(':productId', productId);
                fetch(url, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: '¡Éxito!',
                                text: 'El producto se agregó al carrito correctamente.',
                            });

                        } else {
                            alert("Error al agregar el producto al carrito.");
                        }
                    })
                    .catch(error => {
                        console.error("Ocurrió un error:", error);
                    });
            });
        });
    });
</script>
