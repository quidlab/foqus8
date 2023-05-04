<?php

namespace App\Controllers\API;

use App\Controllers\Controller;
use App\Models\User;
use Lib\Hash\Hash;

class UsersController extends Controller
{
    public function index()
    {
        return response()->json(
            User::get()
        );
    }



    /* 
    
    */
    public function store()
    {
        $data['user-id'] = $_POST['user-id'];
        $data['user-name'] = $_POST['user-name'];
        $data['password'] = Hash::make(($_POST['password']));
        $data['email'] = $_POST['email'];
        $data['role-id'] = $_POST['role-id'];
        $data['mobile'] = $_POST['mobile'];
        $data['preferred-language'] = $_POST['preferred-language'];



        $result = User::create($data);

        if ($result) {
            logger()->info('User Created New User.'
                . '| user-id:' . $_SESSION['uname'] .
                '| new-user-id: ' . $data['user-id'] .
                '| IP: ' . app()->getUserIP() .
                '| time:' . date('Y-m-d H:i:s'));
        } else {
            logger()->info('User Faild To Created New User.
            user-id:' . $_SESSION['uname'] .
                '| new-user-id: ' . $data['user-id'] .
                '| IP: ' . app()->getUserIP() .
                '| time:' . date('Y-m-d H:i:s'));
        }

        back()->withMessage(__($result ? 'created' : 'something-went-wrong'), $result);
    }


    /* 
    
    */
    public function destroy()
    {
        parse_str(file_get_contents("php://input"), $_DELETE);
        $result = User::delete($_DELETE['user-id']);
        return response()->json(
            [
                'message' => __($result ? 'deleted' : 'something-went-wrong'),
                'status' => $result
            ]
        );
    }


    /* 
    
    */
    public function update()
    {
        $data = request()->only(['user-name', 'email', 'role-id', 'mobile', 'preferred-language', 'active']);
        $userID = request()->only('user-id');
        $password = request()->only('password');
        $newData =            [
            $data['user-name'],
            $data['email'],
            $data['role-id'],
            $data['mobile'],
            $data['preferred-language'],
            $data['active'],
            $userID
        ];
        $passStr = "";
        if ($password) {
            $password = Hash::make(request()->only('password'));
            $passStr = "password ='$password' ,";
        }
        $result = database()->Run(
            "UPDATE users set " . $passStr . "[user-name] = ?,email = ? ,[role-id] = ?, mobile = ?, [preferred-language] =? ,active = ? where [user-id] = ?",
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
    public function import()
    {

        $validator = validator([ // NEXT create lower-case and other password complexity
            'name' => 'Jse',
            'obile' => 'se',
        ], [
            'name' => ['required','contains-uppercase'],
            'mobile' => ['required'],
        ]);


        try {
            $data = $validator->validate();
            print_r($data);
        } catch (\Throwable $th) {
           print_r($th->errorsBag);
        }

    }
}
