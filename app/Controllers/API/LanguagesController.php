<?php

namespace App\Controllers\API;

use App\Models\Language;

class LanguagesController
{


    public function index()
    {
        return response()->json(Language::get([
            'ID', 'Language_Name', 'Active', 'Approve', 'DisApprove', 'Abstain', 'NoVote', 'Void'
        ]));
    }


    /* 
    
    */
    public function update()
    {
        // return print_r(Language::update(request()->only(['Active','Approve','DisApprove','Abstain','NoVote','Void'])));
        $sql = "UPDATE Languages set Approve = ?,DisApprove=?,Active=?,Abstain=?,NoVote = ?,Void = ? where ID= ?";
        $data = request()->only(['Active', 'Approve', 'DisApprove', 'Abstain', 'NoVote', 'Void', 'ID']);
        $result = database()->Run(
            $sql,
            [
                $data['Approve'],
                $data['DisApprove'],
                $data['Active'],
                $data['Abstain'],
                $data['NoVote'],
                $data['Void'],
                $data['ID'],
            ]
        );


        return response()->json([
            'status' => $result,
            'message' => __($result ? 'updated' : 'something-went-wrong')
        ]);
    }
}
