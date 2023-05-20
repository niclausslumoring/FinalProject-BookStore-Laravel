<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.5/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.5/dist/sweetalert2.all.min.js"></script>

    <title>Document</title>
</head>
<body>
    @extends('layout')
@section('pageTitle', 'Your Cart')
@section('content')
<form action="checkout-cart" >
    <div class="container">
        <div class="row mt-4">
            <p style="display:none">{{ $user = Auth::user(); }}</p>
            <div class="col-md-2">
                <h6>Book Name</h6>
            </div>
            <div class="col-md-2">
                <h6>Book Author</h6>
            </div>
            <div class="col-md-1">
                <h6>Price</h6>
            </div>
            <div class="col-md-2">
                <h6>Quantity</h6>
            </div>
            <div class="col-md-2">
                <h6>Sub Total</h6>
            </div>
            <div class="col-md-2">
                <h6>Action</h6>
            </div>
        </div>
        <?php $total = 0 ?>
        @if(count($carts) > 0)
            @foreach ($carts as $cart)
                <div class="row">
                    <hr>
                    <div class="col-md-2">
                        <p>{{ $cart->book->title }}</p>
                    </div>
                    <div class="col-md-2">
                        <p>{{ $cart->book->author }}</p>
                    </div>
                    <div class="col-md-1">
                        <p>{{ $cart->book->price }}</p>
                    </div>
                    <div class="col-md-2">
                        @if ($cart->quantity < 2)
                            <p>{{ $cart->quantity }} book</p>  
                        @else
                            <p>{{ $cart->quantity }} books</p> 
                        @endif
                    </div>
                    <div class="col-md-2">
                        <p>{{ $cart->book->price * $cart->quantity}} </p>
                    </div>
                    <div class="col-sm-3 gap-2 d-flex">
                        <form class="d-inline">
                            <a href="/book-detail/{{ $cart->book_id }}/{{ $cart->quantity }}/{{$cart->id}}" class="btn btn-sm btn-primary d-inline">
                                Edit
                            </a>
                        </form>
                        
                        <form action="/delete-cart/{{$cart->id}}" method="post" class="d-inline">
                            {{ csrf_field() }}
                            {{ method_field('delete') }}
                            <input type="hidden" name="book_id" value="{{ $cart->book_id }}">
                            <button class="btn btn-sm btn-danger" type="submit">Remove</button>
                        </form>

                        
                    </div>
                </div>
            @endforeach
            <hr>
            <h5>Grand Total: {{ $total }}</h5>
            <div class="row">
                <div class="col-md-3">
                    {{ csrf_field() }}
                    <button type="submit" class="btn btn-success">Checkout</button>
                </div> 
            </div>
        @else
            <div class="row">
                <hr>
                <h5>No data</h5>
            </div>
        @endif   
       
    </div> 
</form>
    @include('sweetalert::alert')
@endsection
</body>
</html>
