<?php

namespace App\Http\Controllers;

use App\Faculty;
use Illuminate\Http\Request;

class FacultyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fac_list = Faculty::all();

        return view('faculties.index')
            ->with('fac_list', $fac_list)
            ->with('title', 'Faculties | ' . env('APP_NAME'));
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        //Validation
        $this->validate($request, [
            'name' => 'required|string',
            'full' => 'required|string'
        ], [], [
            'name' => 'Faculty Short Name',
            'full' => 'Faculty Full Name'
        ]);

        $fac = new Faculty();
        $fac->fac_short_name = $request['name'];
        $fac->fac_name = $request['full'];
        $fac->save();

        return $fac->fac_id;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Faculty  $faculty
     * @return \Illuminate\Http\Response
     */
    public function show(Faculty $faculty)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Faculty  $faculty
     * @return \Illuminate\Http\Response
     */
    public function edit(Faculty $faculty)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  integer $faculty
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, int $faculty)
    {
        //Validation
        $this->validate($request, [
            'name' => 'required|string',
            'full' => 'required|string'
        ], [], [
            'name' => 'Faculty Short Name',
            'full' => 'Faculty Full Name'
        ]);

        $fac = Faculty::find($faculty);
        $fac->fac_short_name = $request['name'];
        $fac->fac_name = $request['full'];
        $fac->save();

        return $fac->fac_id;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  integer  $faculty
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $faculty)
    {
        $fac = Faculty::find($faculty);
        $fac->delete();

        return $fac->fac_id;
    }
}
