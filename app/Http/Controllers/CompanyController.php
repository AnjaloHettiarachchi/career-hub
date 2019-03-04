<?php

namespace App\Http\Controllers;

use App\AreaOfExpertise;
use App\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as Auth;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:company');
    }

    public function showHome()
    {
        $com_details = DB::table('companies')
            ->where('com_user_id', Auth::guard('company')->user()->getAuthIdentifier())
            ->get()
            ->first();

        $com_aoe = DB::table('areas_of_expertise')
            ->where('aoe_id', $com_details->aoe_id)
            ->pluck('aoe_name')
            ->first();

        $com_op_count = DB::table('opportunities')
            ->where('com_id', $com_details->com_id)
            ->count();

        return view('companies.home')
            ->with('com_details', $com_details)
            ->with('com_aoe', $com_aoe)
            ->with('com_op_count', $com_op_count)
            ->with('title', $com_details->com_title . ' | ' . env('APP_NAME'));
    }

    public function showCreate()
    {
        return view('companies.create')->with('title', 'Company › Create Account | ' . env('APP_NAME'));
    }

    public function doCreate(Request $request)
    {

        //Validation
        $this->validate($request, [
            'avatar' => 'image|mimes:jpeg,png,jpg,gif,svg|size:16000',
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

        return redirect()->route('companies.home');

    }

}
