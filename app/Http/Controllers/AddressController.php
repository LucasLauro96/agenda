<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Address; 

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $Adresses = Address::where('people_id', '=', $id)->get();
        return view('address.index', compact('Adresses', 'id'));
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
            'cep' => 'required',
            'street' => 'required',
            'neighborhood' => 'required',
            'city' => 'required',
            'state' => 'required',
            'number' => 'required'
        ];

        $request->validate($rules);

        $Address =  new Address;
        $Address->cep = $request->cep;
        $Address->street = $request->street;
        $Address->neighborhood = $request->neighborhood;
        $Address->city = $request->city;
        $Address->state = $request->state;
        $Address->number = $request->number;
        $Address->people_id = $request->id;
        $Address->save();
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
        $Address = Address::find($id);
        return $Address;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $rules = [
            'modalCep' => 'required',
            'modalStreet' => 'required',
            'modalNeighborhood' => 'required',
            'modalCity' => 'required',
            'modalState' => 'required',
            'modalNumber' => 'required'
        ];

        $Address = Address::find($request->modalId);
        $Address->cep = $request->modalCep;
        $Address->street = $request->modalStreet;
        $Address->neighborhood = $request->modalNeighborhood;
        $Address->city = $request->modalCity;
        $Address->state = $request->modalState;
        $Address->number = $request->modalNumber;
        $Address->save();
        return redirect('/address/' . $Address->people_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Address = Address::find($id);
        $id = $Address->people_id;
        $Address->delete();
        return redirect('/address/' . $id);
    }
}
