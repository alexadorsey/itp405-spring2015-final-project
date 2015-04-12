<?php namespace App\Http\Controllers;


use Illuminate\Support\Facades\Request;
use App\Http\Controllers\View;

use App\User;
use Hash;
use Auth;

class LoginController extends Controller {
	
	/**************************************/
	/* Sign Up */
	public function signup() {
		return view('signup', [
			'title' => 'Sign Up',
		]);
	}

	public function postSignup(Request $request) { 
		$validation = User::validate(Request::all());
		if ($validation->passes()) {
			$user = new User();
			$user->first_name = Request::input('first-name');
			$user->last_name = Request::input('last-name');
			$user->email = Request::input('email');
			$user->password = Hash::make(Request::input('password'));
			$user->save();
			
			Auth::loginUsingId($user->id); // Logs in the newly created user
			return redirect('dashboard');
			//return redirect('login');
		}
		return redirect('signup')->withErrors($validation->errors());
	}
	
	
	/**************************************/
	/* Log In */
	public function login() {
		return view('login', [
			'title' => 'Login',
		]);
	}
	
	public function postLogin(Request $request) {
		$credentials = [
			'email'=>Request::input('email'),
			'password'=>Request::input('password')
		];
    
		$remember_me = Request::input('remember_me') == 'on' ? true : false;
    
		if (Auth::attempt($credentials, $remember_me)) {
			return redirect()->intended(); // redirect where the user intended to go before login
			 //return redirect('dashboard'); 
		}
		return redirect('login')->with('fail', 'Email and/or password incorrect.');
	}
	
	
	
	public function logout() {
		Auth::logout();
		return redirect('login');
	}

}
