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
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use PhpOffice\PhpWord\Exception\CopyFileException;
use PhpOffice\PhpWord\Exception\CreateTemporaryFileException;
use PhpOffice\PhpWord\TemplateProcessor;
use Swift_Attachment;
use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;

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
                'saveSkills',
                'sortOpportunities',
                'getSortedOpportunities',
                'generateLetter',
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

    public function sortOpportunities($stu_id)
    {
        $test = array();

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
                    ->where('stu_id', $stu_id)
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

            array_push($test, array(
                "op_id" => $op,
                "total" => $total,
                "num" => $num,
                "min" => $min
            ));

            // print "<h1>Total: $total</h1><br><br>";
        }

        // print_r(array_reverse(array_column($this->op_sort($test), 'op_id')));

        // print "<pre>";
        // print_r($this->op_sort($test));
        // print "</pre>";

        return array_reverse(array_column($this->sort_array($test), 'op_id'));

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

    public function getSortedOpportunities($array)
    {
        $res = array();

        foreach ($array as $value) {

            $op = DB::table('opportunities AS op')
                ->leftJoin('companies AS com', 'com.com_id', '=', 'op.com_id')
                ->where('op.op_id', $value)
                ->get();

            array_push($res, $op);

        }

        return $res;

    }

    public function generateLetter()
    {
        $stu_id = Input::get('stu_id');
        $com_id = Input::get('com_id');

        $stu_details = DB::table('students AS stu')
            ->where('stu_id', $stu_id)
            ->leftJoin('degree_programs AS deg', 'deg.deg_id', '=', 'stu.deg_id')
            ->leftJoin('universities AS uni', 'uni.uni_id', '=', 'deg.uni_id')
            ->get()->first();
        $com_detail = Company::query()->where('com_id', $com_id)->get()->first();

        $TMP_DOC_FILE = storage_path() . '/app/public/tmp/' . now()->format('Ymdhi') . '_' . $stu_details->stu_prov_id . '_request_letter.docx';
        $TMP_PDF_FILE = storage_path() . '/app/public/tmp/' . now()->format('Ymdhi') . '_' . $stu_details->stu_prov_id . '_request_letter.pdf';

        // Generate doc using template
        try {
            $tp = new TemplateProcessor(storage_path() . '/app/public/Request_Letter_Template.docx');

            $tp->setValue('date', date('d.m.Y'));
            $tp->setValue('des_to_add', 'Manager - Human Resources');
            $tp->setValue('com_name', $this->xmlEscape($com_detail->com_title));

            $add_lines = explode("\r\n", $this->xmlEscape($com_detail->com_address));
            $tp->setValue('add1', $add_lines[0]);
            $tp->setValue('add2', $add_lines[1]);
            $tp->setValue('add3', $add_lines[2]);

            $tp->setValue('stu_name', $stu_details->stu_full_name);
            if ($stu_details->uni_id == 5 || $stu_details->uni_short_code == 'UGC') {
                $tp->setValue('stu_degree', $stu_details->deg_title . ' - approved by University Grant Commission, Sri Lanka');
            } else {
                $tp->setValue('stu_degree', $stu_details->deg_title . ' - offered in affiliation with ' . $stu_details->uni_title);
            }
            $tp->setValue('stu_id', $stu_details->stu_prov_id);

            $tp->saveAs($TMP_DOC_FILE);

        } catch (CopyFileException $e) {
            return json_encode(['error' => $e->getMessage()]);
        } catch (CreateTemporaryFileException $e) {
            return json_encode(['error' => $e->getMessage()]);
        }

        // Convert doc to PDF
        if (file_exists($TMP_DOC_FILE)) {
            shell_exec('unoconv -f pdf -o ' . $TMP_PDF_FILE . ' ' . $TMP_DOC_FILE);
        }

        // Attach PDF and email
        $EMAIL_HOST = env('EMAIL_HOST');
        $EMAIL_PORT = env('EMAIL_PORT');
        $EMAIL_SECURITY = env('EMAIL_SECURITY');
        $EMAIL_USERNAME = env('EMAIL_USERNAME');
        $EMAIL_PASSWORD = base64_decode(env('EMAIL_PASSWORD'));

        $transport = (new Swift_SmtpTransport($EMAIL_HOST, $EMAIL_PORT, $EMAIL_SECURITY))
            ->setUsername($EMAIL_USERNAME)
            ->setPassword($EMAIL_PASSWORD);
        $mailer = new Swift_Mailer($transport);
        $message = new Swift_Message();

        $full_name = explode(" ", $stu_details->stu_full_name);
        $first_name = reset($full_name);
        $last_name = end($full_name);
        $year = now()->format('Y');

        $email_body = "
                   <h1>Hello $first_name $last_name,</h1>
                   <p>
                   The letter you have requested for <b>$com_detail->com_title</b> is attached below. As this is a system generated email notification, if you have any inquiries or need assistance please contact 
                   NSBM Career Guidance Unit on (011) 544 5067 or email your concern to careerguidance@nsbm.lk.
                   <br>
                   <br>
                   We wish you good luck with your Career Life.
                   <br>
                   ~ CareerHub Team
                   <br>
                   <br>
                   <div style='background-color: #e3e3e3;text-align: center;padding: 1%'>
                        <small> Copyright © $year <strong>National School of Business Management Ltd.</strong> All Rights Reserved.</small>
                   </div>
                   </p>
        ";

        $message
            ->setSubject('Request Letter for ' . $com_detail->com_title)
            ->setFrom([$EMAIL_USERNAME => env('APP_NAME') . ' - NSBM Career Guidance Unit'])
            ->setTo([$stu_details->stu_email => $stu_details->stu_full_name])
            ->setBody($email_body, 'text/html')
            ->attach(Swift_Attachment::fromPath($TMP_PDF_FILE));

        $result = $mailer->send($message);

        if ($result != 0) {
            unlink($TMP_PDF_FILE);
            unlink($TMP_DOC_FILE);
            return json_encode(['success' => 'Email sent successfully']);
        } else {
            unlink($TMP_PDF_FILE);
            unlink($TMP_DOC_FILE);
            return json_encode(['error' => 'Error occurred while sending the email']);
        }

    }

    function xmlEscape($string)
    {
        return str_replace(array('&', '<', '>', '\'', '"'), array('&amp;', '&lt;', '&gt;', '&apos;', '&quot;'), $string);
    }

}
