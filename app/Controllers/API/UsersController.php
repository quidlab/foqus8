<?php

namespace App\Controllers\API;

use App\Controllers\Controller;
use App\Models\User;
use Lib\Hash\Hash;
use Lib\Services\Excel\Excel;

class UsersController extends Controller
{
    public function index()
    {

        if ( $_SESSION['ROLE_ID'] == 7 /* super-admin */) {
            $users = User::get();
        }else{
            $sql = "SELECT  [" . implode("],[", User::$readable) . "] FROM " . User::$table . " Where [role-id] <> 7 ";
            $users = database()->Select($sql, []);
        }
        return response()->json(
            $users
        );
    }



    /* 
    
    */
    public function store()
    { //[{"name":"lower-case","value":"contains-lowercase"},{"name":"upper-case","value":"contains-uppercase"},{"name":"special-character","value":"contains-specialcharacter"},{"name":"contains-digit","value":"contains-digit"}]

        $passComp = [
            'required',
            ...(strpos(constant('MC_PASSWORD_COMPLEXITY'), 'l') ? ['contains-lowercase'] : []),
            ...(strpos(constant('MC_PASSWORD_COMPLEXITY'), 'u') ? ['contains-uppercase'] : []),
            ...(strpos(constant('MC_PASSWORD_COMPLEXITY'), 's') ? ['contains-specialcharacter'] : []),
            ...(strpos(constant('MC_PASSWORD_COMPLEXITY'), 'd') ? ['contains-digit'] : []),
        ];


        $validator = validator(request()->dataArray(), [
            'user-id' => ['required'],
            'user-name' => ['required'],
            'password' => $passComp,
            'email' => ['required'],
            'role-id' => ['required'],
            'mobile' => ['required'],
            'preferred-language' => ['required'],
        ]);


        try {
            $data = $validator->validate();
            $data['password'] = Hash::make($data['password']);
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

            back()->withSuccess([
                'user' => __($result ? 'created' : 'something-went-wrong')
            ]);
        } catch (\Throwable $th) {

            logger()->info('User Faild To Created New User.
            user-id:' . $_SESSION['uname'] .
                '| new-user-id: ' . $data['user-id'] .
                '| IP: ' . app()->getUserIP() .
                '| time:' . date('Y-m-d H:i:s'));

            back()->withErrors($th->errorsBag);
        }
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
    public function import($data)
    {
        $excel = Excel::import('excel-file');
        $passComp = [
            'required',
            ...(strpos(constant('MC_PASSWORD_COMPLEXITY'), 'l') ? ['contains-lowercase'] : []),
            ...(strpos(constant('MC_PASSWORD_COMPLEXITY'), 'u') ? ['contains-uppercase'] : []),
            ...(strpos(constant('MC_PASSWORD_COMPLEXITY'), 's') ? ['contains-specialcharacter'] : []),
            ...(strpos(constant('MC_PASSWORD_COMPLEXITY'), 'd') ? ['contains-digit'] : []),
        ];
        $data = [];


        foreach ($excel->rows() as $row) {
            $validator = validator($row, [
                'user-id' => ['required'],
                'user-name' => ['required'],
                'password' => $passComp,
                'email' => ['required'],
                'role-id' => ['required'],
                'mobile' => ['required'],
                'preferred-language' => ['required'],
            ]);
            try {
                $data[] = $validator->validate();
            } catch (\Throwable $th) {
                return back()->withErrors($th->errorsBag);
            }
        }

        $result = database()->transaction(function () use ($passComp, $excel,$data) {
            foreach ($data as $row) {
                $row['password'] = Hash::make($row['password']);

                if (!User::create($row)) {
                    return false;
                    break;
                }
            }
            return true;
        });

        if ($result) {
            return back()->withSuccess([
                'excel' => 'data uploaded successfully'
            ]);
        } else {
            return back()->withErrors([
                'excel' => 'something-went-wrong'
            ]);
        }
    }
}
