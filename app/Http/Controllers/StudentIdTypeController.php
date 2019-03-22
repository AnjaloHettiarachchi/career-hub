<?php

namespace App\Http\Controllers;

use App\StudentIdType;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class StudentIdTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sit_list = StudentIdType::all();

        return view('student_id_types.index')
            ->with('sit_list', $sit_list)
            ->with('title', 'Student ID Types | ' . env('APP_NAME'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function create()
    {
        // return DataTables::of(StudentIdType::all())->make();
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
            'name' => 'required',
            'length' => 'required|integer'
        ], [], [
            'name' => 'Student ID Type Name',
            'length' => 'Student ID Type Length'
        ]);

        $sit = new StudentIdType();
        $sit->sit_name = $request['name'];
        $sit->sit_length = $request['length'];
        $sit->save();

        return $sit->sit_id;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\StudentIdType  $studentIdType
     * @return \Illuminate\Http\Response
     */
    public function show(StudentIdType $studentIdType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\StudentIdType  $studentIdType
     * @return \Illuminate\Http\Response
     */
    public function edit(StudentIdType $studentIdType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  integer $studentIdType
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, int $studentIdType)
    {
        $this->validate($request, [
            'name' => 'required',
            'length' => 'required|integer'
        ], [], [
            'name' => 'Student ID Type Name',
            'length' => 'Student ID Type Length'
        ]);

        $sit = StudentIdType::find($studentIdType);
        $sit->sit_name = $request['name'];
        $sit->sit_length = $request['length'];
        $sit->save();

        return $sit->sit_id;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  integer  $studentIdType
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $studentIdType)
    {
        $sit = StudentIdType::find($studentIdType);
        $sit->delete();

        return $sit->sit_id;
    }
}
