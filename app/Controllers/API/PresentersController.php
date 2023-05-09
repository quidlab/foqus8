<?php

namespace App\Controllers\API;

use App\Controllers\Controller;
use App\Models\Presenter;
use App\Models\User;
use Lib\Hash\Hash;
use Lib\Services\Excel\Excel;

class PresentersController extends Controller
{
    public function index()
    {
        return response()->json(
            Presenter::get()
        );
    }


    public function store()
    {
        $passComp = [
            'required',
            ...(strpos(constant('MC_PASSWORD_COMPLEXITY'), 'l') ? ['contains-lowercase'] : []),
            ...(strpos(constant('MC_PASSWORD_COMPLEXITY'), 'u') ? ['contains-uppercase'] : []),
            ...(strpos(constant('MC_PASSWORD_COMPLEXITY'), 's') ? ['contains-specialcharacter'] : []),
            ...(strpos(constant('MC_PASSWORD_COMPLEXITY'), 'd') ? ['contains-digit'] : []),
            ...(constant('MC_MINIMUM_PASSWORD_LENGTH') !== NULL ? ['min:' . constant('MC_MINIMUM_PASSWORD_LENGTH')] : [])
        ];
        $validator = validator(request()->dataArray(), [
            'user-name' => ['required'],
            'first-name' => ['required'],
            'last-name' => ['required'],
            'title' => ['required'],
            'email' => ['required'],
            'password' =>  $passComp,
            'mobile' => ['required'],
            'role' => ['required'],
        ]);

        try {
            $data = $validator->validate();
            $data['password'] = Hash::encrypt($data['password'], $data['user-name']);
            Presenter::create($data);

            return back()->withSuccess([
                'presenter' => __('created')
            ]);
        } catch (\Throwable $th) {
            back()->withErrors($th->errorsBag);
        }
    }



    /* 
    
    */
    public function update()
    {
        $validator = validator(request()->dataArray(), [
            'user-name' => ['required'],
            'first-name' => ['required'],
            'last-name' => ['required'],
            'title' => ['required'],
            'email' => ['required'],
            'mobile' => ['required'],
            'role' => ['required'],
        ]);
        try {
            $data = $validator->validate();
        } catch (\Throwable $th) {
            return response()->json([
                'errors' => $th->errorsBag
            ], 422);
        }



        $password = request()->only('password');
        $passStr = '';
        if ($password  != '') {
            $passComp = [
                'required',
                ...(strpos(constant('MC_PASSWORD_COMPLEXITY'), 'l') ? ['contains-lowercase'] : []),
                ...(strpos(constant('MC_PASSWORD_COMPLEXITY'), 'u') ? ['contains-uppercase'] : []),
                ...(strpos(constant('MC_PASSWORD_COMPLEXITY'), 's') ? ['contains-specialcharacter'] : []),
                ...(strpos(constant('MC_PASSWORD_COMPLEXITY'), 'd') ? ['contains-digit'] : []),
                ...(constant('MC_MINIMUM_PASSWORD_LENGTH') !== NULL ? ['min:' . constant('MC_MINIMUM_PASSWORD_LENGTH')] : [])
            ];
            $passValidator = validator([
                'password' => $password
            ], [
                'password' => $passComp
            ]);

            try {
                $password = $passValidator->validate();
                $password = Hash::encrypt($password['password'], $data['user-name']);
            } catch (\Throwable $th) {
                return response()->json([
                    'errors' => $th->errorsBag
                ], 422);
            }

            $passStr = "password ='$password' ,";
        }

        $newData =            [
            $data['email'],
            $data['role'],
            $data['mobile'],
            $data['first-name'],
            $data['last-name'],
            $data['title'],
            $data['user-name']
        ];

        $result = database()->Run(
            "UPDATE presenters set " . $passStr . " email = ? ,[role] = ?, mobile = ?, [first-name] = ?,[last-name] = ?,title = ? where [user-name] = ?",
            $newData
        );

        return response()->json(
            [
                'message' => __($result ? 'updated' : 'something-went-wrong'),
                'status' => $result
            ]
        );
    }

    /* 
    
    */
    public function destroy()
    {
        $result = Presenter::delete(request()->only('user-name'));
        return response()->json(
            [
                'message' => __($result ? 'deleted' : 'something-went-wrong'),
                'status' => $result
            ]
        );
    }
}
