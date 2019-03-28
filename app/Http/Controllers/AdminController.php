<?php

namespace App\Http\Controllers;

use App\Admin;
use App\AreaOfExpertise;
use App\Company;
use App\CompanyUser;
use App\DegreeProgram;
use App\Faculty;
use App\Skill;
use App\SkillCategory;
use App\Student;
use App\StudentIdType;
use App\StudentUser;
use App\University;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function showDashboard()
    {
        $aoe_list = AreaOfExpertise::all();
        $com_list = Company::all();
        $dp_list = DegreeProgram::all();
        $fac_list = Faculty::all();
        $uni_list = University::all();
        $skill_cat_list = SkillCategory::all();
        $skill_list = Skill::all();
        $sit_list = StudentIdType::all();
        $stu_list = Student::all();
        $stu_user_list = StudentUser::all();
        $com_user_list = CompanyUser::all();

        return view('admins.dashboard')
            ->with('aoe_list', $aoe_list)
            ->with('com_list', $com_list)
            ->with('dp_list', $dp_list)
            ->with('fac_list', $fac_list)
            ->with('uni_list', $uni_list)
            ->with('skill_cat_list', $skill_cat_list)
            ->with('skill_list', $skill_list)
            ->with('sit_list', $sit_list)
            ->with('stu_list', $stu_list)
            ->with('stu_user_list', $stu_user_list)
            ->with('com_user_list', $com_user_list)
            ->with('title', 'Admin Dashboard | ' . env('APP_NAME'));
    }

    public function showAdminRegister()
    {
        return view('admins.register')->with('title', 'Admin › Register | ' . env('APP_NAME'));
    }

    public function doAdminRegister(Request $request)
    {
        //Validation
        try {
            $this->validate($request, [
                'admin_name' => 'required|regex:^[a-zA-Z0-9_]*$^|min:4',
                'password' => 'required|min:8|confirmed'
            ], [], [
                'admin_name' => 'Username',
                'password' => 'Password'
            ]);
        } catch (ValidationException $e) {
        }

        //Store
        try {
            $admin = new Admin;
            $admin->admin_name = $request['admin_name'];
            $admin->admin_password = Hash::make($request['password']);
            $admin->save();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->back()->with('success', 'A new admin account has been successfully created.');

    }

}
