<?php

namespace App\Http\Controllers;

use App\AreaOfExpertise;
use App\Company;
use App\Student;
use App\StudentUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as Auth;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:company')->only(['showCreate', 'doCreate', 'listStudents']);
    }

    public function showHome($id)
    {
        $com_details = DB::table('companies')
            ->where('com_user_id', $id)
            ->get()
            ->first();

        $com_aoe = DB::table('areas_of_expertise')
            ->where('aoe_id', $com_details->aoe_id)
            ->pluck('aoe_name')
            ->first();

        $com_ops = DB::table('opportunities')
            ->where('com_id', $id)
            ->get();

        $com_con_list = DB::table('conversations AS con')
            ->leftJoin('students as stu', 'stu.stu_id', '=', 'con.stu_id')
            ->where('con.com_id', $id)
            ->get();

        $aoe_list = AreaOfExpertise::all();
        $stu_list = Student::all();

        return view('companies.home')
            ->with('com_details', $com_details)
            ->with('com_aoe', $com_aoe)
            ->with('com_ops', $com_ops)
            ->with('aoe_list', $aoe_list)
            ->with('stu_list', $stu_list)
            ->with('com_con_list', $com_con_list)
            ->with('title', $com_details->com_title . ' | ' . env('APP_NAME'));
    }

    public function showCreate()
    {
        $aoe_list = DB::table('areas_of_expertise')->get();
        return view('companies.create')
            ->with('aoe_list', $aoe_list)
            ->with('title', 'Company › Create Account | ' . env('APP_NAME'));
    }

    public function doCreate(Request $request)
    {

        //Validation
        $this->validate($request, [
            'avatar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:16000',
            'aoe' => 'required',
            'aoe_alt' => 'required_if:aoe,==,0',
            'title' => 'required',
            'desc' => 'required',
            'address' => 'required'
        ], [], [
            'avatar' => 'Company Avatar',
            'aoe' => 'Area of Expertise',
            'aoe_alt' => 'Alternate Area of Expertise',
            'title' => 'Company Title',
            'desc' => 'Company Description',
            'address' => 'Company Address'
        ]);

        //Avatar
        $avatar = $request->file('avatar');

        //Store
        $company = new Company();
        $company->com_avatar = $avatar->openFile()->fread($avatar->getSize());
        $company->com_title = $request['title'];
        $company->com_desc = $request['desc'];
        $company->com_address = $request['address'];

        if ($request['aoe'] == 0 && $request['aoe_alt'] != '') {
            $aoe = new AreaOfExpertise();
            $aoe->aoe_name = $request['aoe_alt'];
            $aoe->save();

            $company->aoe_id = $aoe->id;
        } else {
            $company->aoe_id = $request['aoe'];
        }

        $company->com_user_id = Auth::guard('company')->user()->getAuthIdentifier();
        $company->save();

        return redirect()->route('companies.home', $company->com_id);

    }

    public function listStudents()
    {
        $stu_list = DB::table('students')->get(['stu_id', 'stu_full_name AS title']);
        return response()->json($stu_list);
    }

}
