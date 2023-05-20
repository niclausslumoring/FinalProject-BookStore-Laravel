<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        *{
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }
        .grid-product{
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            width: 100%;
            gap: 1rem;
        }  
        .grid-item{
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;
            gap: .5rem;
            padding: 1rem;
            text-align: center;
            width: 100%;
            height: 505px;
        }

        .grid-item img{
            height: 300px !important;
            width: 100%;
            object-fit: cover;
        }
        .grid-item-info{
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            /* gap: 1rem; */
            text-align: center;
            width: 100%;
        }

        .grid-item > *{
            margin: 0;
        }

        .searchBar{
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            width: 100%;
        }

        .clear-button{
            /* width: 100px; */
        }
    </style>    
</head>
<body>
@extends('layout')
@section('pageTitle', 'Home')
@section('content')
@if(isset($search))
    <div class="container mt-3 mb-3">
        <div class="">
            <a href="/" class="btn btn-success">Back</a>
        </div>
    </div>
@endif
<div class="container">
    <div class="grid-product">
        @foreach ($books as $b)
        <div class="" >
            <div class="" >
                <div >
                    <div class="grid-item">
                        <img class="" src="{{\Illuminate\Support\Facades\Storage::url($b->cover)}}" alt="" style="width: 13rem; height: 15rem;">
                        <h6>{{ $b->title }}</h4>
                            <p>{{ $b->author }}</p>
                            <p>{{ $b->price }}</p>
                        <div class="grid-item-info">
                            
                            <a href="/book-detail/{{ $b->id }}" class="btn btn-outline-success">View Details</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        @endforeach  
    </div>
    <div class=" m-3 d-flex justify-content-center">
        {{ $books->links() }}
    </div>
</div>
@endsection
</body>
</html>