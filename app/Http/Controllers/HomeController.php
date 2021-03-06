<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
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
     */
    public function index()
    {
        if (Auth::user()->role_id == '1' || Auth::user()->role_id == '2') {
            return view('home');
        }
        return response()->redirectToRoute('bookshelf');
    }
}
