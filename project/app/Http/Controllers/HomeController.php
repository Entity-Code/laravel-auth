<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;

class HomeController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function sendMail(Request $request) {
        $data = $request -> validate([
            'mailText' => 'required|min:5'
        ]);
		//la inviamo all'user collegato
        Mail::to(Auth::user() -> email)
		//$data['StringaPassataNelForm']
            -> send(new TestMail($data['mailText'])); 
        return redirect() -> back();
    }
    
    public function index()
    {
        return view('home');
    }
}
