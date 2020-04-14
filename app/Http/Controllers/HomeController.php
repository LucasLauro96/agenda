<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Person;
use App\Category;
use App\Address; 
use App\Phone; 
use App\User;
use DB;

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
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $User = User::find(session('login_web_59ba36addc2b2f9401580f014c7f58ea4e30989d'));
        session(['email' => $User['email']]);

        $Categories = Person::all()->count();
        $Persons = Person::where('user_id', '=', session('login_web_59ba36addc2b2f9401580f014c7f58ea4e30989d'))->count();

        $Phones = DB::table('phones')
                    ->join('people', 'phones.people_id', '=', 'people.id')
                    ->select(DB::raw('count(*) as qtde'))
                    ->where('people.user_id', '=', session('login_web_59ba36addc2b2f9401580f014c7f58ea4e30989d'))
                    ->whereNull('people.deleted_at')
                    ->whereNull('phones.deleted_at')
                    ->get();
        $Phones = json_decode($Phones);

        $Addresses = DB::table('addresses')
                    ->join('people', 'addresses.people_id', '=', 'people.id')
                    ->select(DB::raw('count(*) as qtde'))
                    ->where('people.user_id', '=', session('login_web_59ba36addc2b2f9401580f014c7f58ea4e30989d'))
                    ->whereNull('people.deleted_at')
                    ->whereNull('addresses.deleted_at')
                    ->get();
        $Addresses = json_decode($Addresses);

        return view('home', compact('Categories', 'Persons', 'Phones', 'Addresses'));
    }
}
