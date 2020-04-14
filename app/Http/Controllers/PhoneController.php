<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
 
use App\Phone; 

class PhoneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $Phones = Phone::where('people_id', '=', $id)->get();
        return view('phone.index', compact('Phones', 'id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'phone' => 'required'
        ];

        $request->validate($rules);

        $Phone = new Phone;
        $Phone->people_id = $request->id;
        $Phone->phone = $request->phone;
        $Phone->save();
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $Phone = Phone::find($id);
        return $Phone;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $rules = [
            'modalPhone' => 'required'
        ];

        $request->validate($rules);
        
        $Phone = Phone::find($request->modalId);
        $Phone->phone = $request->modalPhone;
        $Phone->save();
        return redirect('/phone/' . $Phone->people_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Phone = Phone::find($id);
        $id = $Phone->people_id;
        $Phone->delete();
        return redirect('/phone/' . $id);
    }
}
