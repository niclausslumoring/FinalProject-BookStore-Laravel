@extends('layout')
@section('pageTitle', 'Transaction Detail')
@section('content')
    <div class="container">
        <div class="row mt-4">
            <p style="display:none">{{ $user = Auth::user(); }}</p>
            <div class="col-md-2">
                <h6>Book Name</h6>
            </div>
            <div class="col-md-2">
                <h6>Book Author</h6>
            </div>
            <div class="col-md-2">
                <h6>Price</h6>
            </div>
            <div class="col-md-2">
                <h6>Quantity</h6>
            </div>
            <div class="col-md-1">
                <h6>Sub Total</h6>
            </div>
            <div class="col-md-3">
                <h6>Action</h6>
            </div>
        </div>
        <?php $total = 0 ?>
        @foreach ($transDetail as $t)
                    <?php $total += $t->quantity * $t->book->price ?>
                        <div class="row">
                        <hr>
                        <div class="col-md-2">
                            <p>{{ $t->book->title }}</p>
                        </div>
                        <div class="col-md-2">
                            <p>{{ $t->book->author }}</p>
                        </div>
                        <div class="col-md-2">
                            <p>{{ $t->book->price }}</p>
                        </div>
                        <div class="col-md-2">
                            <p>{{ $t->quantity }}</p>
                        </div>
                        <div class="col-md-1">
                            {{ $t->quantity * $t->book->price }}
                        </div>
                        <div class="col-sm-auto">
                            <a href="/book-detail/{{ $t->book_id }}">
                                <button class="btn btn-sm btn-secondary">View Book Detail</button>
                            </a>
                        </div>
        @endforeach
        <hr>
        <h6>Grand Total: IDR {{ $total }}</h6>
    </div> 
    </div>
@endsection