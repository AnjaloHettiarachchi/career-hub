<?php

namespace App\Http\Controllers;

use App\Achievement;
use App\AchievementSkill;
use App\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AchievementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $stu_full_name = DB::table('students')
            ->where('stu_user_id', Auth::guard('student')->user()->getAuthIdentifier())
            ->pluck('stu_full_name')
            ->first();

        return view('achievements.create')
            ->with('stu_full_name', $stu_full_name)
            ->with('title', 'Achievement › Create | ' . env('APP_NAME'));
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
        $this->validate($request, [
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:16000',
            'title' => 'required',
            'desc' => 'required',
            'skills' => 'required'
        ], [], [
            'image' => 'Achievement Image',
            'title' => 'Achievement Title',
            'desc' => 'Achievement Description',
            'skills' => 'Achievement Skills'
        ]);

        $stu_id = DB::table('students')
            ->where('stu_user_id', Auth::guard('student')->user()->getAuthIdentifier())
            ->pluck('stu_id')
            ->first();

        $ach = new Achievement();
        $image = $request->file('banner');
        if ($image != null) {
            $ach->ach_image = $image->openFile()->fread($image->getSize());
        }
        $ach->ach_title = $request['title'];
        $ach->ach_desc = $request['desc'];
        $ach->stu_id = $stu_id;
        $ach->save();
        $new_ach_id = $ach->ach_id;

        $skills = explode(',', $request['skills']);

        for ($i = 0; $i < count($skills); $i++) {
            $ach_skills = new AchievementSkill();
            $ach_skills->ach_id = $new_ach_id;
            $ach_skills->skill_id = $skills[$i];
            $ach_skills->save();
        }

        return redirect()->route('students.home', $stu_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  integer  $achievement
     * @return \Illuminate\Http\Response
     */
    public function show(int $achievement)
    {
        $ach_details = Achievement::find($achievement);
        $stu_details = Student::find($ach_details->stu_id);
        $ach_skills = DB::table('achievement_skills AS as')
            ->leftJoin('achievements AS ac', 'ac.ach_id', '=', 'as.ach_id')
            ->leftJoin('skills AS sk', 'sk.skill_id', '=', 'as.skill_id')
            ->leftJoin('skill_categories as sct', 'sct.skill_cat_id', '=', 'sk.skill_cat_id')
            ->where('ac.ach_id', $achievement)
            ->get();

        return view('achievements.show')
            ->with('ach_details', $ach_details)
            ->with('stu_details', $stu_details)
            ->with('ach_skills', $ach_skills)
            ->with('title', $ach_details->ach_title . ' | ' . env('APP_NAME'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Achievement  $achievement
     * @return \Illuminate\Http\Response
     */
    public function edit(Achievement $achievement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Achievement  $achievement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Achievement $achievement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Achievement  $achievement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Achievement $achievement)
    {
        //
    }
}
