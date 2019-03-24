<?php

namespace App\Http\Controllers;

use App\DegreeProgram;
use App\Faculty;
use App\University;
use Illuminate\Http\Request;

class DegreeProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fac_list = Faculty::all();
        $uni_list = University::all();
        $deg_list = DegreeProgram::all();

        return view('degree_programs.index')
            ->with('fac_list', $fac_list)
            ->with('uni_list', $uni_list)
            ->with('deg_list', $deg_list)
            ->with('title', 'Degree Programs | ' . env('APP_NAME'));
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
            'uni' => 'required',
            'fac' => 'required',
            'title' => 'required|string'
        ], [], [
            'uni' => 'Degree Program\'s University',
            'fac' => 'Degree Program\'s Faculty',
            'title' => 'Degree Program Title'
        ]);

        $deg = new DegreeProgram();
        $deg->deg_title = $request['title'];
        $deg->fac_id = $request['fac'];
        $deg->uni_id = $request['uni'];
        $deg->save();

        return $deg->deg_id;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\DegreeProgram  $degreeProgram
     * @return \Illuminate\Http\Response
     */
    public function show(DegreeProgram $degreeProgram)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DegreeProgram  $degreeProgram
     * @return \Illuminate\Http\Response
     */
    public function edit(DegreeProgram $degreeProgram)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  integer $degreeProgram
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, int $degreeProgram)
    {
        //Validation
        $this->validate($request, [
            'uni' => 'required',
            'fac' => 'required',
            'title' => 'required|string'
        ], [], [
            'uni' => 'Degree Program\'s University',
            'fac' => 'Degree Program\'s Faculty',
            'title' => 'Degree Program Title'
        ]);

        $deg = DegreeProgram::find($degreeProgram);
        $deg->deg_title = $request['title'];
        $deg->fac_id = $request['fac'];
        $deg->uni_id = $request['uni'];
        $deg->save();

        return $deg->deg_id;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  integer $degreeProgram
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $degreeProgram)
    {
        $deg = DegreeProgram::find($degreeProgram);
        $deg->delete();

        return $deg->deg_id;
    }
}
