@extends('layouts.app')


@section('content')
    @if (isset($cart) && count($cart) > 0)
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Precio</th>
                                <th>Cantidad</th>
                                <th>Subtotal</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cart as $product)
                                <tr>
                                    <td>{{ $product['name'] }}</td>
                                    <td>{{ $product['price'] }}</td>
                                    <td>
                                        <input type="number" min="1" value="{{ $product['quantity'] }}"
                                            onchange="updateQuantity('{{ $product['id'] }}', this.value)">
                                    </td>
                                    <td>{{ $product['price'] * $product['quantity'] }}</td>
                                    <td>
                                        <button class="btn btn-danger" onclick="removeFromCart('{{ $product['id'] }}')"><i
                                                class="bi bi-trash"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <button onclick="checkout()">Comprar</button>
                </div>
            </div>
        </div>
    @else
        @if (session('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: '{{ session('success') }}',
                });
            </script>
        @endif
        <div class="text-center">
            <p>No hay productos en el carrito.</p>
        </div>
    @endif
@endsection

<script>
    function removeFromCart(productId) {
        // Mostrar un cuadro de diálogo de confirmación
        Swal.fire({
            title: 'Confirmación',
            text: '¿Estás seguro de que quieres eliminar este producto del carrito?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí',
            cancelButtonText: 'No'
        }).then((result) => {
            if (result.isConfirmed) {
                // Realizar la solicitud AJAX para eliminar el producto del carrito
                const url = "{{ route('cart.remove', ['productId' => ':productId']) }}";
                const removeUrl = url.replace(':productId', productId);

                fetch(url, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            productId: productId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // El producto se ha eliminado correctamente
                            location.reload();
                        }
                    })
                    .catch(error => {
                        console.error("Ocurrió un error:", error);
                    });
            }
        });
    }

    function updateQuantity(productId, quantity) {
        // Realizar una solicitud AJAX para actualizar la cantidad del producto en el carrito
        const url = "{{ route('cart.update', ['productId' => ':productId']) }}";
        const updateUrl = url.replace(':productId', productId);

        fetch(updateUrl, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    productId: productId,
                    quantity: quantity
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // La cantidad se ha actualizado correctamente
                    location.reload();
                }
            })
            .catch(error => {
                console.error("Ocurrió un error:", error);
            });
    }

    function checkout() {
        window.location.href = "{{ route('checkout') }}";

    }
</script>
