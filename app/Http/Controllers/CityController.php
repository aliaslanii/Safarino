<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return City::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return City::factory()->count(30)->create();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $City = new City();
        $City->name = $request->name;
        return $City->save();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $City = City::find($request->id);
        $City->name = $request->name;
        return $City->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
