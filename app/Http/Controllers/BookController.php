<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Cart;
use App\Models\Genre;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function insertBook(Request $request){
        $rules = [
            'title'=>'required',
            'author'=>'required',
            'synopsis'=>'required',
            'price'=>'required|integer',
            'cover'=>'mimes:jpeg,jpg,png,gif|required|max:10000|image',
            'genre'=>'required'
        ];

        $book = new Book();
        $book->title = $request->title;
        $book->genreid = $request->genre;
        $book->author = $request->author;
        $book->synopsis = $request->synopsis;
        $book->price = $request->price;

        $file = $request->file('cover');

        $imageName = time().".".$file->getClientOriginalExtension();
        Storage::putFileAs('public/images', $file, $imageName);

        $book->cover = 'images/'.$imageName;
        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
            return back()->withErrors($validator);
        }
        $book->save();

        return redirect()->back();
    }

    public function updateBook(Request $request, $id){
        $book = Book::find($id);
        $rules = [
            'title'=>'required',
            'author'=>'required',
            'synopsis'=>'required',
            'price'=>'required|integer',
            'cover'=>'mimes:jpeg,jpg,png,gif|required|max:10000|image',
            'genre'=>'required'
        ];
        
        $book->title = $request->title;
        $book->author = $request->author;
        $book->synopsis = $request->synopsis;
        $book->genreid = $request->genre;
        $book->price = $request->price;
        $file = $request->file('cover');
        if($file != null){
            $imageName = time().".".$file->getClientOriginalExtension();
            Storage::delete('public/'.$book->cover);

            $book->cover = 'images/'.$imageName;
            Storage::putFileAs('public/images', $file, $imageName);
        }
        
        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
            return back()->withErrors($validator);
        }

        $book->save();

        return redirect()->back();
    }

    public function showBooks(){
        $books = Book::all();
        $genre = Genre::all();

        return view('manage', compact('books','genre'));
    }

    public function booksHome(){
        $books = Book::paginate(5);
        // dd($books);
        return view('home', compact('books'));
    }

    public function search(Request $request){
        $search = $request->search;
    
        $books = Book::where('title','LIKE','%'.$search.'%')
                       ->paginate(5)
                       ->appends(['search'=>$search]);
        return view('home', compact('books', 'search'));
    }

    public function showBookDetail($id){
        $book = Book::find($id);
        $genres = Genre::all();
        return view('detail',compact('book', 'genres'));
    }

    public function showBookEditDetail($id){
        $book = Book::find($id);
        $genres = Genre::all();
        return view('edit_cart',compact('book', 'genres'));
    }

    public function deleteBook($id){
        $book = Book::find($id);
        $book->delete();
        return redirect()->back();
    }

    public function cart(){
        $userId = auth()->user()->id;
        $carts = Cart::all()->where('user_id', $userId);
        return view('cart', [
            "carts"=>$carts
        ]);
    }

    public function addtoCart(Request $request, Book $book){
        $userId = auth()->user()->id;
        $existingCart = Cart::where('user_id', $userId)
                            ->where('book_id', $book->id)
                            ->first();
        $cart = new Cart();
        $cart->user_id = $userId;
        $cart->book_id = $book->id;
        $cart->quantity = $request->quantity;
        $cart->save();

        return redirect()->back()->with('toast_success','Book added to cart successfully!');
    }
    
    public function editCart(Request $request, $id){
        $cart = Cart::all()->where('book_id',$request->id);
        $cart[0]->quantity = $request->quantity;
        $cart[0]->save();
        return redirect()->back()->with('toast_success','Book added to cart successfully!');
    }

    public function deleteCart(Request $request){
        Cart::destroy($request->id);
        return redirect()->back()->with('toast_success','Delete successful!');
    }

    public function checkout(){
        $cart = Cart::all()->where("user_id", auth()->user()->id);
        foreach($cart as $c){
            $history = new Transaction();
            $history->userid = auth()->user()->id;
            $history->save();
            $transDetail = new TransactionDetail();
            $transDetail->book_id = $c->book_id;
            $transDetail->transaction_id = $history->id;
            $transDetail->quantity = $c->quantity;
            $transDetail->save();
            Cart::destroy($c->id);
        }
        return redirect()->back()->with('toast_success','Checkout successful!');
    }

    public function accessSessionData(Request $request) {
        if($request->session()->has('cart'))
        $cart = $request->session()->get('cart');
        dd($cart);
    }
    public function showAbout()
    {
        return view('aboutus');
    }

}
