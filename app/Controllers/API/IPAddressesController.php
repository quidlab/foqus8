<?php

namespace App\Controllers\API;

use App\Controllers\Controller;
use App\Models\User;
use Lib\Hash\Hash;
use Lib\Services\Excel\Excel;

class IPAddressesController extends Controller
{
    public function index()
    {

        $data = database()->Select("
            Select * From safe_ipaddresses
        ");
        return response()->json(
            $data
        );
    }



    /* 
    
    */
    public function store()
    {
        $validator = validator(request()->dataArray(), [
            'ipaddress' => ['required'],
            'name' => ['nullable'],
        ]);

        try {
            $data = $validator->validate();
            $result = database()->Run(
                "INSERT INTO safe_ipaddresses (ipaddress,name) VALUES (?,?) ",
                [
                    $data['ipaddress'],
                    $data['name'],
                ]
            );

            return response()->json([
                'message' => __($result ? 'created' : 'something-went-wrong'),
                'status' => $result
            ]);
        } catch (\Throwable $th) {


            back()->withErrors($th->errorsBag);
        }
    }


    /* 
    
    */
    public function destroy()
    {
        $result = database()->Run("
        DELETE FROM safe_ipaddresses Where ipaddress = ?
        ", [request()->only('ipaddress')]);
        return response()->json(
            [
                'message' => __($result ? 'deleted' : 'something-went-wrong'),
                'status' => $result
            ]
        );
    }
}
