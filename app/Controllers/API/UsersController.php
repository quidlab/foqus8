<?php

namespace App\Controllers\API;

use App\Controllers\Controller;
use App\Models\User;

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
        $data['password'] = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $data['email'] = $_POST['email'];
        $data['role-id'] = $_POST['role-id'];


        $result = User::create($data);

        if ($result) {
            logger()->info('User Created New User.'
            .'| user-id:' . $_SESSION['uname'] .
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
    public function destroy(){
        parse_str(file_get_contents("php://input"), $_DELETE);
        $result = User::delete($_DELETE['user-id']);
        return response()->json([
            'message' => __( $result ? 'deleted' : 'something-went-wrong'),
            'status' => $result
            ]
        );
    }
    
}
