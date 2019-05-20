<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class AdminSectionsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function students()
    {
        $stu_list = DB::table('students')
            ->leftJoin('student_id_types AS sit', 'sit.sit_id', '=', 'students.sit_id')
            ->leftJoin('degree_programs AS deg', 'deg.deg_id', '=', 'students.deg_id')
            ->leftJoin('faculties AS fac', 'fac.fac_id', '=', 'deg.fac_id')
            ->leftJoin('universities AS uni', 'uni.uni_id', '=', 'deg.uni_id')
            ->select([
                'stu_id',
                'stu_avatar',
                'stu_prov_id',
                'stu_full_name',
                'stu_bio',
                'stu_con_num',
                'stu_email',
                'sit.sit_name',
                'deg.deg_title',
                'uni.uni_title',
                'fac.fac_short_name',
                'students.created_at AS joined_on',
                'students.updated_at AS updated_on'
            ])->get();

        return view('admins.sections.students')
            ->with('stu_list', $stu_list)
            ->with('title', 'Student Accounts | ' . env('APP_NAME'));
    }

    public function companies()
    {
        $com_list = DB::table('companies AS com')
            ->leftJoin('areas_of_expertise AS aoe', 'aoe.aoe_id', '=', 'com.com_id')
            ->select([
                'com_id',
                'com_avatar',
                'com_title',
                'com_desc',
                'com_address',
                'aoe_name',
                'com.created_at AS joined_on',
                'com.updated_at AS updated_on'
            ])->get();

        return view('admins.sections.companies')
            ->with('com_list', $com_list)
            ->with('title', 'Companies | ' . env('APP_NAME'));
    }
}
