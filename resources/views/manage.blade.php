@extends('layout')
@section('pageTitle', 'Manage Books')
@section('content')
    <div class= "p-3 border">
        <form action="/manage-book" method="post" enctype="multipart/form-data">
            {{csrf_field()}}
            <p class="fs-4">Insert Product Form</p>
            <div class="row mb-3">
                <label for="exampleFormControlInput1" class="col-sm-2 col-form-label">Name</label>
                <div class="col-sm-10">
                    <input class="form-control @error('title') is-invalid @enderror" type="text" aria-label="default input example" name="title">
                    <div class="row">
                        <span style="color: red">@error('title')
                            {{ 'Name is required'}}
                        @enderror</span>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <label for="exampleFormControlInput1" class="col-sm-2 col-form-label">Brand</label>
                <div class="col-sm-10">
                    <input class="form-control @error('author') is-invalid @enderror" type="text" aria-label="default input example" name="author">
                    <div class="row">
                        <span style="color: red">@error('author')
                            {{ 'Author is required'}}
                        @enderror</span>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <label for="exampleFormControlInput1" class="col-sm-2 col-form-label">Description</label>
                <div class="col-sm-10">
                    <textarea class="form-control @error('synopsis') is-invalid @enderror" id="exampleFormControlTextarea1" rows="10" name="synopsis"></textarea>
                    <div class="row">
                        <span style="color: red">@error('synopsis')
                            {{ 'Synopsis is required'}}
                        @enderror</span>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <label for="exampleFormControlInput1" class="col-sm-2 col-form-label">Type</label>
                <div class="col-sm-9">
                    <div class="row">
                    @foreach ($genre as $gen)
                        <div class="col-md-4">
                            <input class="form-check-input" type="radio" id="checkbox{{$gen->id}}" name="genre" value="{{$gen->id}}">
                            <label for="checkbox{{$gen->id}}" class="form-check-label me-2">{{ $gen->name }}</label>
                        </div>
                    @endforeach
                    </div>
                    <div class="row">
                        <span style="color: red">@error('genre')
                            {{ 'Genre is required'}}
                        @enderror</span>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <label for="exampleFormControlInput1" class="col-sm-2 col-form-label">Price</label>
                <div class="col-sm-10">
                    <input class="form-control @error('price') is-invalid @enderror" name="price" type="text" aria-label="default input example">
                    <div class="row">
                        <span style="color: red">@error('price')
                            {{ 'Price is required'}}
                        @enderror</span>
                    </div>
                </div>
            </div>
                <div class="row mb-3">
                    <label for="exampleFormControlInput1" class="col-sm-2 col-form-label">Cover</label>
                    <div class="col-sm-10">
                        <input class="form-control @error('cover') is-invalid @enderror" name="cover" type="file" id="formFile">
                        <div class="row">
                            <span style="color: red">@error('cover')
                                {{ 'Cover is required'}}
                            @enderror</span>
                        </div>
                    </div>
                </div>
            <button type="submit" class="btn btn-primary">Import</button>
        </form>
    </div>
    <div>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Brand</th>
                <th scope="col">Description</th>
                <th scope="col">Type</th>
                <th scope="col">Price</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($books as $b)
                    <tr>
                        <td>{{ $b->title }}</td>
                        <td>{{ $b->author }}</td>
                        <td>{{ $b->synopsis }}</td>
                        <td>{{ $genre[ $b->genreid - 1]->name }}</td>
                        <td>{{ $b->price }}</td>
                        <td>
                            <div class="col sm-2">
                                <a href="/book-detail/{{ $b->id }}">
                                    <button class="btn btn-sm btn-secondary">Details</button>
                                </a>
                            </div>
                        </td>
                        <td>
                            <div class="col sm-1">
                                <form action="/delete-book/{{ $b->id }}" method="post">
                                    {{ csrf_field() }}
                                    {{ method_field('delete') }}
                                    <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
