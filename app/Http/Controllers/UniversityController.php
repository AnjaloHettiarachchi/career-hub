<?php

namespace App\Http\Controllers;

use App\University;
use Illuminate\Http\Request;

class UniversityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $uni_list = University::all();

        return view('universities.index')
            ->with('uni_list', $uni_list)
            ->with('title', 'Universities | ' . env('APP_NAME'));
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
            'short' => 'required|string|min:3',
            'title' => 'required|string'
        ], [], [
            'short' => 'University Short Code',
            'title' => 'University Title'
        ]);

        $uni = new University();
        $uni->uni_short_code = $request['short'];
        $uni->uni_title = $request['title'];
        $uni->save();

        return $uni->uni_id;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\University  $university
     * @return \Illuminate\Http\Response
     */
    public function show(University $university)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\University  $university
     * @return \Illuminate\Http\Response
     */
    public function edit(University $university)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  integer $university
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, int $university)
    {
        //Validation
        $this->validate($request, [
            'short' => 'required|string|min:3',
            'title' => 'required|string'
        ], [], [
            'short' => 'University Short Code',
            'title' => 'University Title'
        ]);

        $uni = University::find($university);
        $uni->uni_short_code = $request['short'];
        $uni->uni_title = $request['title'];
        $uni->save();

        return $uni->uni_id;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  integer  $university
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $university)
    {
        $uni = University::find($university);
        $uni->delete();

        return $uni->uni_id;
    }
}
