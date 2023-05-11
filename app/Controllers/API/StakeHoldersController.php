<?php

namespace App\Controllers\API;

use App\Controllers\Controller;
use App\Exceptions\ValidationException;

class StakeHoldersController extends Controller
{

    public function index()
    {
        $data = database()->Select("SELECT * From [StakeHolders]");
        return response()->json($data);
    }



    /* 
    
    */
    public function store()
    {
        $validator = validator(request()->dataArray(), [
            'i_holder' => ['required'], // MOSTAFA_TODO => Create NUMBER RULE
            'vote-type' => ['required'],
            'Agenda_ID' => ['required'],
            'q_share' => ['required'],
        ]);

        try {
            $data = $validator->validate();
        } catch (ValidationException $th) {
            return response()->json([
                'message' => $th->errorsBag,
                'status' => false
            ]);
        }

        $result = database()->Run(
            "INSERT INTO StakeHolders (i_holder,[vote-type],Agenda_ID,q_share) VALUES (?,?,?,?)",
            [
                $data['i_holder'],
                $data['vote-type'],
                $data['Agenda_ID'],
                $data['q_share'],
            ]
        );

        return response()->json([
            'message' => __($result ? 'created' : 'somthing-went-wrong'),
            'status' => $result
        ]);
    }



    /* 
    
    */
    public function update(){
        $validator = validator(request()->dataArray(), [
            'i_holder' => ['required'], // MOSTAFA_TODO => Create NUMBER RULE
            'vote-type' => ['required'],
            'Agenda_ID' => ['required'],
            'q_share' => ['required'],
        ]);

        try {
            $data = $validator->validate();
        } catch (ValidationException $th) {
            return response()->json([
                'message' => $th->errorsBag,
                'status' => false
            ]);
        }

        $result = database()->Run("UPDATE StakeHolders SET [i_holder] = ?, [vote-type] = ? ,[Agenda_ID] = ?,[q_share] = ? WHERE Agenda_ID = ? AND q_share = ?", [
            $data['i_holder'],
            $data['vote-type'],
            $data['Agenda_ID'],
            $data['q_share'],
            $data['Agenda_ID'],
            $data['q_share'],
        ]);
        return response()->json([
            'message' => __($result ? 'updated' : 'somthing-went-wrong'),
            'status' => $result
        ]);
    }





    /* 
    
    */
    public function destroy()
    {
        $validator = validator(request()->dataArray(), [
            'i_holder' => ['required'],
            'Agenda_ID' => ['required'],
        ]);

        try {
            $data = $validator->validate();
        } catch (ValidationException $th) {
            return response()->json([
                'message' => $th->errorsBag,
                'status' => false
            ]);
        }

        $result = database()->Run("DELETE FROM StakeHolders WHERE i_holder = ? AND Agenda_ID = ?", [
            $data['i_holder'],
            $data['Agenda_ID'],
        ]);
        return response()->json([
            'message' => __($result ? 'deleted' : 'somthing-went-wrong'),
            'status' => $result
        ]);
    }
}
