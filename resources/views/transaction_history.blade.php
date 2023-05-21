@extends('layout')
@section('pageTitle', 'Transaction History')
@section('content')
    <div class="container">
        <div class="row mt-4">
            <p style="display:none">{{ $user = Auth::user(); }}</p>
            <div class="col-md-3">
                <h6>TransactionID</h6>
            </div>
            <div class="col-md-3">
                <h6>Date</h6>
            </div>
            <div class="col-md-2">
                
            </div>
            <div class="col-md-4">
                <h6>Action</h6>
            </div>
        </div>
        @foreach ($transaction as $t)
                <div class="row">
                    <hr>
                    <div class="col-md-3">
                        <p>{{ $t->id }}</p>
                    </div>
                    <div class="col-md-3">
                        <p>{{ $t->created_at }}</p>
                    </div>
                    <div class="col-md-2">
                        <p></p>
                    </div>
                    <div class="col-sm-auto">
                        <a href="/transaction-detail/{{$t->id}}">
                            <button class="btn btn-sm btn-secondary">View Transaction Detail</button>
                        </a>
                    </div>
                </div>
        @endforeach
    </div> 
@endsection