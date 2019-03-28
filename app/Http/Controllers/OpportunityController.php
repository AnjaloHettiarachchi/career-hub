<?php

namespace App\Http\Controllers;

use App\Company;
use App\CompanyUser;
use App\Opportunity;
use App\OpportunitySkill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OpportunityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $com_id = Company::where('com_user_id', Auth::guard('company')->user()->getAuthIdentifier())
            ->pluck('com_id')
            ->first();

        $ops = Opportunity::where('com_id', $com_id)->get();
        return $ops;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $com_title = DB::table('companies')
            ->where('com_user_id', Auth::guard('company')->user()->getAuthIdentifier())
            ->pluck('com_title')
            ->first();

        return view('opportunities.create')
            ->with('com_title', $com_title)
            ->with('title', 'Opportunity › Create | ' . env('APP_NAME'));
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
            'banner' => 'image|mimes:jpeg,png,jpg,gif,svg|max:16000',
            'title' => 'required',
            'desc' => 'required',
            'skills' => 'required'
        ]);

        $com_id = DB::table('companies')
            ->where('com_user_id', Auth::guard('company')->user()->getAuthIdentifier())
            ->pluck('com_id')
            ->first();

        $op = new Opportunity();
        $banner = $request->file('banner');
        if ($banner != null) {
            $op->op_banner = $banner->openFile()->fread($banner->getSize());
        }
        $op->op_title = $request['title'];
        $op->op_desc = $request['desc'];
        $op->com_id = $com_id;
        $op->save();
        $new_op_id = $op->op_id;

        $skills = explode(',', $request['skills']);
        for ($i = 0; $i < count($skills); $i+=2) {
            $op_skills = new OpportunitySkill();
            $op_skills->op_id = $new_op_id;
            $op_skills->skill_id = $skills[$i];
            $op_skills->op_skill_level = $skills[$i+1];
            $op_skills->save();
        }

        return redirect()->route('companies.home', $com_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $op_details = Opportunity::find($id);
        $com_details = Company::find($op_details->com_id);
        $op_skills = DB::table('opportunity_skills AS os')
            ->leftJoin('skills AS sk', 'sk.skill_id', '=', 'os.skill_id')
            ->leftJoin('skill_categories as sct', 'sct.skill_cat_id', '=', 'sk.skill_cat_id')
            ->where('os.op_id', $id)
            ->get();

        return view('opportunities.show')
            ->with('op_details', $op_details)
            ->with('com_details', $com_details)
            ->with('op_skills', $op_skills)
            ->with('title', $op_details->op_title . ' | ' . env('APP_NAME'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
