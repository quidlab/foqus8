<?php

namespace App\Controllers;

use App\Models\User;
use Lib\Hash\Hash;

class ProfileController extends Controller
{
    public function index()
    {
    }

    /* 
    
    */

    public function update()
    {
        $data = validator(request()->dataArray(),[
            'email' => ['required','email'],
            'mobile' => ['required'],
            'preferred-language' => ['required'],
        ])->validate();

        $pass = request()->only('password');
        if ($pass) {
            $data['password'] = Hash::make($pass);
        }
        User::update($data,$_SESSION['uname']);
        return back()->withSuccess([
            'message' => 'updated'
        ]);
    }


    /* 
    
    */


}
