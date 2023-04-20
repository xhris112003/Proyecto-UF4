@extends('layouts.app')
 
@section('content')
<div class="container">
     <iv class="row jusify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div cass="card-header"></div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </dv>
                    @endif
                    @foreach ($products as $product)
                    <div>
                        <h2>{{ $product['name'] }}</h2>
                        <p>{{ $product['description'] }}</p>
                        <p>Precio: {{ $product['price'] }}</p>
                    </div>
                    @endforeach
                </div>
             </div>
    

        </div>
    </div>
</ div>
    

@endsection