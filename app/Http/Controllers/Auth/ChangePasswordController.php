<?php

namespace App\Http\Controllers\Auth;
   
use Illuminate\Http\Request;
use App\Rules\Auth\MatchOldPassword;
use Illuminate\Support\Facades\Hash;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Http\Controllers\BaseXCS;
  
class ChangePasswordController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
   
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function store(Request $request)
    {
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required', 'string', 'min:8'],
            'new_confirm_password' => ['same:new_password'],
        ]);
   
        User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);
        if(User::find(auth()->user()->id)->get('temp_password')) {
        	User::find(auth()->user()->id)->update(['temp_password' => 0]);
        }
    }
}