<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rules\CheckOldPassword;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class PasswordController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function view(){
        return view('password');
    }

    public function changePass(Request $request){
        $request->validate([
            'current_pass' => ['required', new CheckOldPassword],
            'new_pass' => 'required|min:8|different:current_pass',
            'new_confirm_pass'=>'same   :new_pass|required',
        ]);
        User::find(auth()->user()->id)->update(['password'=>Hash::make($request->new_pass)]);
        Alert::success('Password', 'has changed');
        return redirect()->back();
    }
}
