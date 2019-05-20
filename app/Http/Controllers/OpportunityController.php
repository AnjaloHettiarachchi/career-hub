<?php

namespace App\Http\Controllers;

use App\Company;
use App\CompanyUser;
use App\Opportunity;
use App\OpportunitySkill;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class OpportunityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
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
     * @return Response
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
     * @param Request $request
     * @return Response
     * @throws ValidationException
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
     * @return Response
     */
    public function show($id)
    {
        $op_details = Opportunity::find($id);
        $com_details = Company::find($op_details->com_id);
        $candidate_list = $this->getSortedCandidates($this->sortCandidates($id));

        $op_skills = DB::table('opportunity_skills AS os')
            ->leftJoin('skills AS sk', 'sk.skill_id', '=', 'os.skill_id')
            ->leftJoin('skill_categories as sct', 'sct.skill_cat_id', '=', 'sk.skill_cat_id')
            ->where('os.op_id', $id)
            ->get();

        return view('opportunities.show')
            ->with('op_details', $op_details)
            ->with('com_details', $com_details)
            ->with('op_skills', $op_skills)
            ->with('candi_list', $candidate_list)
            ->with('title', $op_details->op_title . ' | ' . env('APP_NAME'));
    }

    public function sortCandidates($op_id)
    {
        $candiArray = array();

        $students = DB::table('students')
            ->pluck('stu_id')
            ->toArray();

        foreach ($students as $student) {
            $current_stu_union = DB::table('student_skills')
                ->where('stu_id', $student)
                ->get(['skill_id'])
                ->toArray();

            $total = 0;
            $min = 0;
            $num = 0;

            foreach ($current_stu_union as $stu_union) {
                $stu_skill_level = DB::table('student_skills')
                    ->where('skill_id', $stu_union->skill_id)
                    ->where('stu_id', $student)
                    ->pluck('stu_skill_level')
                    ->first();

                if (!$stu_skill_level) {
                    $stu_skill_level = 0;
                }

                $op_skill_level = DB::table('opportunity_skills')
                    ->where('skill_id', $stu_union->skill_id)
                    ->where('op_id', $op_id)
                    ->pluck('op_skill_level')
                    ->first();

                if (!$op_skill_level) {
                    $op_skill_level = 0;
                }

                if (($stu_skill_level - $op_skill_level) < 0) {
                    $num += 1;
                }

                $total += ($stu_skill_level - $op_skill_level);

                if ($min == 0) {
                    $min = ($stu_skill_level - $op_skill_level);
                } elseif ($min > ($stu_skill_level - $op_skill_level)) {
                    $min = ($stu_skill_level - $op_skill_level);
                }
            }

            array_push($candiArray, array(
                "stu_id" => $student,
                "total" => $total,
                "num" => $num,
                "min" => $min
            ));

        }

        return array_reverse(array_column($this->sort_array($candiArray), 'stu_id'));
    }

    public function sort_array($array)
    {
        usort($array, function ($a, $b) {
            $res = $a['total'] <=> $b['total'];
            if ($res == 0) {
                $res = $a['min'] <=> $b['min'];
                if ($res == 0) {
                    $res = $a['num'] <=> $b['num'];
                }
            }
            return $res;
        });

        return $array;
    }

    public function getSortedCandidates($array)
    {
        $res = array();

        foreach ($array as $value) {

            $op = DB::table('students AS stu')
                ->leftJoin('degree_programs AS deg', 'deg.deg_id', '=', 'stu.deg_id')
                ->leftJoin('universities AS uni', 'uni.uni_id', '=', 'deg.uni_id')
                ->where('stu.stu_id', $value)
                ->get();

            array_push($res, $op);

        }

        return $res;

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
