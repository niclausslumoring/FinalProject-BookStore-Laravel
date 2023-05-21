<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Book;
use App\Models\TransactionDetail;
use App\Models\Transaction;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    public function loginPage(){
        return view('login');
    }

    public function login(Request $request){
        $request->validate([
            'email'=> 'required|email',
            'password'=> 'required'
        ]);
        $email = $request->email;
        $password = $request->password;
        $remember_me = $request->remember_me;
        $isValid = auth()->attempt(['email'=>$email,'password'=>$password]);

        if($isValid){
            if($remember_me){
                Cookie::queue('email',$email,10080);
                Cookie::queue('password',$password,10080);
            }
            return redirect('/');
        }else{
            return back()->withErrors(new MessageBag(['Invalid email/password']));
        }
    }

    public function logout(Request $request){
        auth()->logout();
        $request->session()->forget('cart');
        return redirect('/');
    }

    public function register(Request $request){
        $this->validate($request,[
            'email' => 'required|email|unique:users,email',
            'fullname' => 'required',
            'vat_number' => 'max:13',
            'password' => 'required|confirmed|min:8',
            'password_confirmation' =>'min:8|same:password'
        ]); 
        $user = new User();
        $user->roleid = 2;
        $user->email = $request->email;
        $user->password= Hash::make($request->password);
        $user->fullname = $request->fullname;
        $saved = $user->save();

        if($saved){
            return redirect('/')->with('success',"Account Successfully Registered");
        }else{
            return back()->withErrors(new MessageBag(['Invalid data']));
        }
    }

    public function registerPage(){
        return view('register');
    }

    public function displayUser(){
        $user = User::all();
        $role = Role::all();
        return view('manage_user',compact('user','role'));
    }

    public function deleteUser($id){
        $user = User::find($id);
        $user->delete();
        return redirect()->back();
    }
    
    public function profilePage(){
        $user = User::all();
        $role = Role::all();
        return view('profile',compact('user','role'));
    }
    
    public function userDetail($id){
        $user = User::find($id);
        $role = Role::all();
        return view('user_detail',compact('user','role'));
    }

    public function transactionHistory(){
        $transaction = Transaction::all()->where("userid", auth()->user()->id);
        return view('transaction_history',compact('transaction'));
    }

    public function transactionDetail(Request $request){
        $transDetail = TransactionDetail::all()->where("transaction_id", $request->id);
        return view('transaction_detail',compact('transDetail'));
    }
    
    public function updateProfile(Request $request, $id){
        $rules = [
            'fullname'=> 'required',
        ];
        $user = User::find($id);
        $user->fullname = $request->fullname;
        $validator = Validator::make($request->all(),$rules);

        if($validator->fails()){
            return back()->withErrors($validator);
        }
        $user->save();
        Alert::success('Profile', 'has been updated');
        return redirect()->back();
    }

    public function updateUserDetail(Request $request, $id){
        $rules = [
            'fullname'=> 'required',
            'email'=>'required|email',
            'rolename'=> 'required|in:Admin,Member'
        ];
        $user = User::find($id);
        $user->fullname = $request->fullname;
        $user->email = $request->email;
        if($request->rolename == "Admin"){
            $user->roleid = 1;
        }else{
            $user->roleid = 2;
        }
        $validator = Validator::make($request->all(),$rules);

        if($validator->fails()){
            return back()->withErrors($validator);
        }
        $user->save();
        Alert::success('Profile', 'has been updated');
        return redirect()->back();
    }

    public function password(){
        $user = User::all();

        return view('password',compact('user'));
    }
}
