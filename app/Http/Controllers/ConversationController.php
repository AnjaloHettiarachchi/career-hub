<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use App\Conversation;

class ConversationController extends Controller
{
    /**
     * @param Request $request
     * @throws ValidationException
     */
    public function store(Request $request)
    {

        //Validation
        $this->validate($request, [
            'stu_id' => 'required|integer',
            'com_id' => 'required|integer',
            'doc_id' => 'required|string'
        ]);

        $con = new Conversation();
        $con->stu_id = $request['stu_id'];
        $con->com_id = $request['com_id'];
        $con->con_doc_id = $request['doc_id'];
        $con->save();

    }

    /**
     * @param Request $request
     * @return string
     * @throws ValidationException
     */
    public function getDocId(Request $request)
    {

        //Validation
        $this->validate($request, [
            'stu_id' => 'required|integer',
            'com_id' => 'required|integer',
        ]);

        return DB::table('conversations')
            ->where('stu_id', '=', $request['stu_id'])
            ->where('com_id', '=', $request['com_id'])
            ->pluck('con_doc_id')->first();

    }

}
