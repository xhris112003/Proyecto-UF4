@extends('layouts.app')


@section('content')
<div class="d-flex justify-content-center">
<table class="table"> 
    <thead>
        <tr>
            <th>ID_producto_comprado</th>
            <th>Precio producto</th>
            <th>Fecha de compra</th>

            <!-- Agrega aquí los encabezados de las demás columnas -->
        </tr>
    </thead>
    <tbody>
        @foreach ($purchases as $purchase)
            <tr>
                <td>{{ $purchase->id }}</td>
                <td>{{ $purchase->price }}</td>
                <td>{{ $purchase->created_at }}</td>
                
            </tr>
        @endforeach
    </tbody>
</table>
</div>

@endsection