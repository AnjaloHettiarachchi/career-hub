<?php

namespace App\Http\Controllers;

use App\Company;
use App\Faculty;
use App\Student;
use App\StudentIdType;
use App\StudentSkill;
use App\University;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:student')
            ->only([
                'listDegreePrograms',
                'listCompanies',
                'showCreate',
                'doCreate',
                'showSkills',
                'saveSkills'
            ]);
    }

    public function listDegreePrograms()
    {
        $degs_with_unies = DB::table('degree_programs AS dp')
            ->leftJoin('universities AS uni', 'dp.uni_id', '=', 'uni.uni_id')
            ->get(['deg_id', 'dp.fac_id', 'dp.uni_id', 'deg_title AS title', 'uni_title AS category']);

        return response()->json($degs_with_unies);
    }

    public function listCompanies()
    {
        $com_list = DB::table('companies')->get(['com_id', 'com_title AS title']);

        return response()->json($com_list);
    }

    public function showHome($id)
    {
        $stu_details = DB::table('students AS st')
            ->leftJoin('degree_programs AS dp', 'dp.deg_id', '=', 'st.deg_id')
            ->leftJoin('faculties AS fac', 'fac.fac_id', '=', 'dp.fac_id')
            ->leftJoin('universities AS uni', 'uni.uni_id', '=', 'dp.uni_id')
            ->leftJoin('student_id_types AS sit', 'sit.sit_id', '=', 'st.sit_id')
            ->where('stu_id', $id)
            ->get()->first();

        $stu_skills = DB::table('student_skills AS sts')
            ->leftJoin('skills AS sk', 'sk.skill_id', '=', 'sts.skill_id')
            ->leftJoin('skill_categories AS sc', 'sc.skill_cat_id', '=', 'sk.skill_cat_id')
            ->where('stu_id', $id)
            ->select(['sk.skill_id', 'sk.skill_title', 'sc.skill_cat_id', 'sc.skill_cat_name', 'sts.stu_skill_level', 'sts.created_at', 'sts.updated_at'])
            ->get();

        $stu_achs = DB::table('achievements')
            ->where('stu_id', $id)
            ->get();

        $stu_ach_skills = DB::table('achievement_skills AS as')
            ->leftJoin('achievements AS ac', 'ac.ach_id', '=', 'as.ach_id')
            ->leftJoin('skills AS sk', 'sk.skill_id', '=', 'as.skill_id')
            ->where('ac.stu_id', $id)
            ->get();

        $stu_con_list = DB::table('conversations AS con')
            ->leftJoin('companies as com', 'com.com_id', '=', 'con.com_id')
            ->where('con.stu_id', $id)
            ->get();

        $fac_list = Faculty::all();
        $uni_list = University::all();
        $sit_list = StudentIdType::all();
        $com_list = Company::all();
        $op_list = $this->getSortedOpportunities($this->sortOpportunities($id));

        $name = explode(' ', $stu_details->stu_full_name);
        $first = reset($name);
        $last = end($name);

        return view('students.home')
            ->with('stu_details', $stu_details)
            ->with('stu_skills', $stu_skills)
            ->with('stu_achs', $stu_achs)
            ->with('fac_list', $fac_list)
            ->with('uni_list', $uni_list)
            ->with('sit_list', $sit_list)
            ->with('com_list', $com_list)
            ->with('op_list', $op_list)
            ->with('stu_con_list', $stu_con_list)
            ->with('stu_ach_skills', $stu_ach_skills)
            ->with('title', $first . ' ' . $last . ' | ' . env('APP_NAME'));
    }

    public function showCreate()
    {
        $fac_list = Faculty::all();
        $uni_list = University::all();
        $sit_list = StudentIdType::all();

        return view('students.create')
            ->with('fac_list', $fac_list)
            ->with('uni_list', $uni_list)
            ->with('sit_list', $sit_list)
            ->with('title', 'Student › Create Account | ' . env('APP_NAME'));
    }

    /**
     * @param Request $request
     * @return Response
     * @throws ValidationException
     */
    public function doCreate(Request $request)
    {

        //Validation
        $length = StudentIdType::where('sit_id', $request['sit'])->pluck('sit_length')->first();

        $this->validate($request, [
            'avatar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:16000',
            'deg' => 'required',
            'sit' => 'required',
            'stu_prov_id' => 'required|unique:students|min:' . $length . '|max:' . $length,
            'full_name' => 'required|string',
            'con_num' => 'required|min:14|max:14',
            'stu_email' => 'required|email|unique:students'
        ], [], [
            'avatar' => 'Student Avatar',
            'deg' => 'Student Degree Program',
            'sit' => 'Student ID Card Type',
            'stu_prov_id' => 'Student ID Card No.',
            'full_name' => 'Student Full Name',
            'con_num' => 'Student Contact No.',
            'stu_email' => 'Student Email Address'
        ]);

        //Avatar
        $avatar = $request->file('avatar');

        $stu = new Student();
        $stu->stu_avatar = $avatar->openFile()->fread($avatar->getSize());
        $stu->stu_prov_id = $request['stu_prov_id'];
        $stu->stu_full_name = $request['full_name'];
        $stu->stu_bio = $request['bio'];
        $stu->stu_con_num = $request['con_num'];
        $stu->stu_email = $request['stu_email'];
        $stu->deg_id = $request['deg'];
        $stu->sit_id = $request['sit'];
        $stu->stu_user_id = Auth::guard('student')->user()->getAuthIdentifier();
        $stu->save();

        return redirect()->route('students.home', $stu->stu_id);

    }

    public function showSkills()
    {
        $stu_details = Student::find(Auth::guard('student')->user()->getAuthIdentifier());
        $stu_skills = DB::table('student_skills AS sts')
            ->leftJoin('skills AS sk', 'sk.skill_id', '=', 'sts.skill_id')
            ->leftJoin('skill_categories AS sc', 'sc.skill_cat_id', '=', 'sk.skill_cat_id')
            ->where('stu_id', $stu_details->stu_id)
            ->get();
        $skill_array = DB::table('student_skills')
            ->selectRaw('skill_id, CONCAT(skill_id,",",stu_skill_level) AS stu_skills')
            ->where('stu_id', $stu_details->stu_id)
            ->pluck('stu_skills', 'skill_id')
            ->implode(',');

        return view('students.skills')
            ->with('stu_details', $stu_details)
            ->with('stu_skills', $stu_skills)
            ->with('skill_array', $skill_array)
            ->with('title', 'Student › Skills | ' . env('APP_NAME'));
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function saveSkills(Request $request)
    {
        $this->validate($request, [
            'skill-list' => 'required',
        ], [], [
            'skill-list' => 'Skills'
        ]);

        $stu_id = DB::table('students')
            ->where('stu_user_id', Auth::guard('student')->user()->getAuthIdentifier())
            ->pluck('stu_id')
            ->first();

        $skills = explode(',', $request['skill-list']);

        if (StudentSkill::where('stu_id', $stu_id)->count() > 0) {
            StudentSkill::where('stu_id', $stu_id)->delete();
        }

        for ($i = 0; $i < count($skills); $i += 2) {
            $stu_skills = new StudentSkill();
            $stu_skills->stu_id = $stu_id;
            $stu_skills->skill_id = $skills[$i];
            $stu_skills->stu_skill_level = $skills[$i + 1];
            $stu_skills->save();
        }

        return redirect()->route('students.home', $stu_id);
    }

    public function sortOpportunities($id)
    {
        $test = array();
        $test1 = array();

        $ops = DB::table('opportunities')
            ->pluck('op_id')
            ->toArray();

        foreach ($ops as $op) {
            $current_op_union = DB::table('opportunity_skills')
                ->where('op_id', $op)
                ->get(['skill_id'])
                ->toArray();

            $total = 0;
            $num = 0;
            $min = 0;

            foreach ($current_op_union as $op_uni) {
                $stu_skill_level = DB::table('student_skills')
                    ->where('skill_id', $op_uni->skill_id)
                    ->where('stu_id', $id)
                    ->pluck('stu_skill_level')
                    ->first();

                if (!$stu_skill_level) {
                    $stu_skill_level = 0;
                }

                $op_skill_level = DB::table('opportunity_skills')
                    ->where('skill_id', $op_uni->skill_id)
                    ->where('op_id', $op)
                    ->pluck('op_skill_level')
                    ->first();

                if (!$op_skill_level) {
                    $op_skill_level = 0;
                }

                // print $op_uni->skill_id . " --> " . $stu_skill_level . " - " . $op_skill_level . " = " . ($stu_skill_level - $op_skill_level);

                if (($stu_skill_level - $op_skill_level) < 0) {
                    $num += 1;
                }
                $total += ($stu_skill_level - $op_skill_level);
                if ($min == 0) {
                    $min = ($stu_skill_level - $op_skill_level);
                } elseif ($min > ($stu_skill_level - $op_skill_level)) {
                    $min = ($stu_skill_level - $op_skill_level);
                }
                // print "<br>";
            }

            /* array_push($test, array(
                "op_id" => $op,
                "total" => $total,
                "num" => $num,
                "min" => $min
            )); */

            $test1[$op] = $total;
            // print "<h1>Total: $total</h1><br><br>";
        }

        arsort($test1);
        return $test1;

        // print "<pre>";
        // print_r($test1);
        // print "</pre>";

    }

    public function getSortedOpportunities($array)
    {
        $res = array();

        foreach ($array as $key => $value) {

            $op = DB::table('opportunities AS op')
                ->leftJoin('companies AS com', 'com.com_id', '=', 'op.com_id')
                ->where('op.op_id', $key)
                ->get();

            array_push($res, $op);

        }

        return $res;

    }

}
