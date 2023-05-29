<?php

namespace App\Controllers\API;

use App\Controllers\Controller;
use App\Models\Presenter;
use App\Models\User;
use Lib\Hash\Hash;
use Lib\Mail\PresentersMail;
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
            $data['password'] = constant('MC_ENC_PRESENTERS_PASS') ? Hash::encrypt($data['password'], $data['user-name']) : $data['password'];
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
    public function storeMany()
    {
        $passComp = [
            'required',
            ...(strpos(constant('MC_PASSWORD_COMPLEXITY'), 'l') ? ['contains-lowercase'] : []),
            ...(strpos(constant('MC_PASSWORD_COMPLEXITY'), 'u') ? ['contains-uppercase'] : []),
            ...(strpos(constant('MC_PASSWORD_COMPLEXITY'), 's') ? ['contains-specialcharacter'] : []),
            ...(strpos(constant('MC_PASSWORD_COMPLEXITY'), 'd') ? ['contains-digit'] : []),
            ...(constant('MC_MINIMUM_PASSWORD_LENGTH') !== NULL ? ['min:' . constant('MC_MINIMUM_PASSWORD_LENGTH')] : [])
        ];
        $validator = validator(request()->only(['presenters-count', 'role']), [
            'presenters-count' => ['required'],
            'role' => ['required'],
        ]);


        try {
            $data = $validator->validate();
        } catch (\Throwable $th) {
            back()->withErrors($th->errorsBag);
        }


        $result = database()->transaction(function () use ($data) {
            /* DELETE ALL Presenters With Same Role */
            $deleteResult = Presenter::deleteByColName('role', $data['role']);
            /* === */
            $result = true;
            for ($i = 1; $i <= $data['presenters-count']; $i++) {
                $value = [];
                $value['user-name'] = $data['role'] . $i;
                $value['role'] = $data['role'];
                $value['password'] = Hash::encrypt($this->randomPassword(), $value['user-name']);
                if (!Presenter::create($value)) {
                    $result = false;
                    return $result;
                    break;
                }
            }

            return ($deleteResult && $result);
        });


        if ($result) {
            return back()->withSuccess([
                'message' => 'creaetd'
            ]);
        } else {
            return back()->withErrors([
                'message' => 'somthing-went-wrong'
            ]);
        }
    }



    /* 
        UPDATE
    */
    public function update()
    {
        $validator = validator(request()->dataArray(), [
            'user-name' => ['required'],
            'role' => ['required'],
            'first-name' => ['nullable'],
            'last-name' => ['nullable'],
            'title' => ['nullable'],
            'email' => ['nullable'],
            'mobile' => ['nullable'],
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
                $password = constant('MC_ENC_PRESENTERS_PASS') ?  Hash::encrypt($password['password'], $data['user-name']) : $password;
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
    public function import($data)
    {
        $excel = Excel::import('excel-file');
        $data = [];


        foreach ($excel->rows() as $row) {
            $validator = validator($row, [
                'user-name' => ['required'],
                'first-name' => ['nullable'],
                'last-name' => ['nullable'],
                'title' => ['nullable'],
                'email' => ['nullable'],
                'mobile' => ['nullable'],
                'role' => ['required'],
            ]);
            try {
                $data[] = $validator->validate();
            } catch (\Throwable $th) {
                return response()->json($th->errorsBag, $th->getCode());
            }
        }

        $result = database()->transaction(function () use ($excel, $data) {
            foreach ($data as $row) {

                $row['password'] = constant('MC_ENC_PRESENTERS_PASS') ? Hash::encrypt($this->randomPassword(8), $row['user-name']) : $this->randomPassword(8);

                if (!Presenter::create($row)) {
                    return false;
                    break;
                }
            }
            return true;
        });

        if ($result) {
            return response()->json([
                'message' => 'data uploaded successfully'
            ]);
        } else {
            return response()->json([
                'message' => 'something-went-wrong',
            ], 400);
        }
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


    function randomPassword($len = 8)
    {

        $sets = array();
        $sets[] = 'ABCDEFGHJKLMNPQRSTUVWXYZ';
        $sets[] = 'abcdefghjkmnpqrstuvwxyz';
        $sets[] = '23456789';
        $sets[]  = '~!@#$%^&*(){}[],./?';

        $password = '';

        foreach ($sets as $set) {
            $password .= $set[array_rand(str_split($set))];
        }

        while (strlen($password) < $len) {
            $randomSet = $sets[array_rand($sets)];

            $password .= $randomSet[array_rand(str_split($randomSet))];
        }

        return str_shuffle($password);
    }





    /* 
    
    */
    public function sendMail()
    {
        $validator = validator(request()->dataArray(), [
            'user-name' => ['required']
        ]);
        try {
            $data = $validator->validate();
        } catch (\Throwable $th) {
            return response()->json([
                'errors' => $th->errorsBag
            ], 422);
        }
        $user = Presenter::findByColName('user-name', $data['user-name']);
        $companies = database()->Select("SELECT * FROM company WHERE  Tlang in ( SELECT Language_ID FROM languages WHERE Active=1 ) ORDER BY ID ");
        $cos = [];
        foreach ($companies as $key => $co) {
            $cos[$co['Tlang']] = $co;
        }
        if (!$user) {
            return response()->json([
                'message' => 'user not found'
            ]);
        }

        $mail = new PresentersMail($user->email, $user->{'first-name'}, [
            'Title' => $user->title,
            'FirstName' => $user->{'first-name'},
            'LastName' => $user->{'last-name'},
            'UserName' => $user->{'user-name'},
            'Password' => Hash::decrypt($user->password, $user->{'user-name'}),
            'Company_Name_Thai' => $cos['th']['Company_Name'],
            'Company_Symbol' => constant('MC_SYMBOL'),
            'Support_Link_Thai' => constant('MC_AGM_LINK'),
            'Company_Phone' => constant('MC_COMP_PHONE'),
            'Company_Email' => constant('MC_COMP_EMAIL'),
            'Company_Name_Eng' => $cos['en']['Company_Name'],
            'AGM_ADD_ENG' => constant('MC_AGM_LINK'),
        ]);
        try {
            $mail->send();
            Presenter::update(['email-sent' =>  (int)$user->{'email-sent'} + 1], $user->{'user-name'});
            return response()->json([
                'status' => true,
                'message' => __('mail-sent-message')
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => __('mail-not-sent-message')
            ]);
        }
    }



    public function export()
    {
        $data = validator(request()->dataArray(), [
            'role' => ['required']
        ])->validate();
        $prersenters = $data['role'] == 'all' ? Presenter::get([...(Presenter::$readable), ...(['password'])])
            : Presenter::where('role', $data['role'])::get([...(Presenter::$readable), ...(['password'])]);
        foreach ($prersenters as $key => &$value) {
            $value['password'] = Hash::decrypt($value['password'], $value['user-name']);
        }
        Excel::export(
            [
                'user-name',
                'first-name',
                'last-name',
                'title',
                'role',
                'email',
                'password',
                'email-sent'
            ],
            $prersenters,
            constant('MC_SYMBOL') . "-" . $data['role']
        );
    }
}
