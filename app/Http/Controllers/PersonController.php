<?php

namespace App\Http\Controllers;

use Mail;
use Illuminate\Http\Request;

use App\Person;
use App\Category;
use App\Address; 
use App\Phone; 
use DB;

use App\Notifications\ContactsNotification;

class PersonController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Persons = DB::table('people')
                    ->join('categories', 'categories.id', '=', 'people.category_id')
                    ->select('people.id', 'people.name', 'people.email', 'categories.name as cat')
                    ->where('people.user_id', '=', session('login_web_59ba36addc2b2f9401580f014c7f58ea4e30989d'))
                    ->whereNull('people.deleted_at')
                    ->get();
        $Persons = json_decode($Persons);
        return view('person.index', compact('Persons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $Categories = Category::all();
        return view('person.create', compact('Categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'category_id' => 'required',
            'cep' => 'required',
            'street' => 'required',
            'neighborhood' => 'required',
            'city' => 'required',
            'state' => 'required',
            'number' => 'required'
        ];

        $request->validate($rules);

        $Person = new Person;
        $Person->name = $request->name;
        $Person->email = $request->email;
        $Person->category_id = $request->category_id;
        $Person->user_id = session('login_web_59ba36addc2b2f9401580f014c7f58ea4e30989d');
        $Person->save();

        $Phone = new Phone;
        $Phone->phone = $request->phone;
        $Phone->people_id = $Person->id;
        $Phone->save();
        

        $Address = new Address;
        $Address->cep = $request->cep;
        $Address->street = $request->street;
        $Address->neighborhood = $request->neighborhood;
        $Address->city = $request->city;
        $Address->state = $request->state;
        $Address->number = $request->number;
        $Address->people_id = $Person->id;
        $Address->save();

        // Notifico o usuario que o cadastro do contato foi um sucesso
        $Email = session('email');
        $Name = [
            "name" => $Person->name
        ];
        Mail::to($Email)->send(new \App\Mail\ContactMail($Name));

        return "OK";

        

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $Categories = Category::all();
        $Person = Person::find($id);
        return view('person.edit', compact('Person', 'Categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'category_id' => 'required'
        ];

        $request->validate($rules);

        $person = Person::find($id);
        $person->name = $request->name;
        $person->email = $request->email;
        $person->category_id = $request->category_id;
        $person->save();
        return "OK";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Person = Person::find($id);
        $Person->delete();
        return redirect('/person');
    }

    public function search(Request $request)
    {
        $Persons = DB::table('people')
                    ->join('categories', 'categories.id', '=', 'people.category_id')
                    ->select('people.id', 'people.name', 'people.email', 'categories.name as cat')
                    ->where('people.user_id', '=', session('login_web_59ba36addc2b2f9401580f014c7f58ea4e30989d'))
                    ->where('people.name', 'like', '%' . $request->search . '%')
                    ->whereNull('people.deleted_at')
                    ->get();
        $Persons = json_decode($Persons);
        return view('person.index', compact('Persons'));
    }
}
