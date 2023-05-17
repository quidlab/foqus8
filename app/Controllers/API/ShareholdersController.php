<?php

namespace App\Controllers\API;

use App\Controllers\Controller;
use App\Models\Shareholder;
use Lib\Hash\Hash;
use Lib\Mail\ShareholderMail;
use Lib\Services\Excel\Excel;

class ShareholdersController extends Controller
{

    public function index()
    {
        $data = database()->Select("SELECT TOP (10) * from EGM");
        foreach ($data as $key => &$value) {
            if ($value['password'] && $value['username']) {
                $value['password'] = Hash::decrypt($value['password'], $value['username']);
            }
        }
        return response()->json($data);
    }



    /* 
    
    */
    public function import()
    {
        $excel = Excel::import('file_name');


        $r = database()->transaction(function () use ($excel) {
            $sql = "DELETE FROM AgendaResults;Delete from EGM;DBCC CHECKIDENT ('EGM', RESEED, 11111110);";
            $r1 = database()->Run($sql);
            $rows = [];
            foreach ($excel->only(['Account_ID', 'q_share', 'n_title', 'n_first', 'i_ref', 'h_phone', 'i_zip', 'a_holder', 'n_last'], true) as $key => $row) {
                $rows[$key] = $row;
                $rows[$key]['i_holder'] = $row['Account_ID'];
                $rows[$key]['a_holder_1'] = $row['a_holder'];
                $rows[$key]['I_ref'] = $row['i_ref'];
                unset($rows[$key]['Account_ID']);
                unset($rows[$key]['a_holder']);
                unset($rows[$key]['i_ref']);
            }

            $r2 = Shareholder::createMany($rows, Shareholder::readable(), 1000);

            $r3 = database()->Run("UPDATE EGM SET Attended = 'N', Shares_Attended = 0, Proxy = 'N', Proxy_name = '', BallotPaperPrinted = 0, Custodian = 'N', USER_ID = '', Registered_Time = NULL, Out_Time = NULL,org_q_share=q_share,Group_id=NULL,serial=0,coupon1_claimed='N',coupon2_claimed='N',coupon3_claimed='N',feedback_submitted='N',factory_visit_interested='N',org_n_first=n_first,org_n_last=n_last,org_i_ref=I_ref,ProxyType=NULL,email=NULL,m_phone=NULL,username=NULL,password=NULL,ApprovedForOnline='N',IPAddress=NULL,lastlogin=NULL,status=0,active=0,[email-sent]=0,doc_received='N',jitsiid='0';");
            return ($r1 && $r2 && $r3);
        });


        return response()->json([
            'status' => $r,
            'message' => __($r ? 'imported' : 'faild')
        ]);
    }


    /* 
    
    */
    public function update()
    {
        $validator = validator(request()->dataArray(), [
            'email' => ['nullable'],
            'password' => ['nullable'],
            'username' => ['nullable'],
            'f_status' => ['nullable'],
        ]);


        try {
            $data = $validator->validate();
            if ($data['password']) {
                $data['password'] = Hash::encrypt($data['password'], request()->only('ID'));
            }
            $u = Shareholder::update($data, request()->only('ID'));
            return response()->json([
                'message' => __('updated'),
                'status' => true,
                'l' => $u
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'errors' => $th->errorsBag
            ], 422);
        }
    }

    /* 
    
    */
    public function sendEmail()
    {
        $validator = validator(request()->dataArray(), [
            'ID' => ['required']
        ]);
        try {
            $data = $validator->validate();
        } catch (\Throwable $th) {
            return response()->json([
                'errors' => $th->errorsBag
            ], 422);
        }
        $user = Shareholder::findByColName('ID', $data['ID']);
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
        if (empty($user->email)) {
            return response()->json([
                'message' => 'Invalid Email' // MOSTAFA_TODO Create ValidEmail rule
            ]);
        }

        $mail = new ShareholderMail($user->email, $user->n_first, [
            'Title' => $user->n_title,
            'FirstName' => $user->n_first,
            'LastName' => $user->n_last,
            'UserName' => $user->username,
            'Password' => Hash::decrypt($user->password, $user->ID),
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
            Shareholder::update(['email-sent' =>  (int)$user->{'email-sent'} + 1], $user->{'ID'});
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



    /* 
    
    */
    public function sendMany()
    {
        $shareholders = database()->Select("SELECT * FROM EGM WHERE email <> '' AND [email-sent] = 0");
        if ($shareholders == null) {
            return response()->json([
                'message' => 'All Sent',
                'status' => true
            ]);
        }
        $companies = database()->Select("SELECT * FROM company WHERE  Tlang in ( SELECT Language_ID FROM languages WHERE Active=1 ) ORDER BY ID ");
        $cos = [];
        foreach ($companies as $key => $co) {
            $cos[$co['Tlang']] = $co;
        }
        foreach ($shareholders as $key => $value) {
            $mail = new ShareholderMail($value['email'], $value['n_first'], [
                'Title' => $value['n_title'],
                'FirstName' => $value['n_first'],
                'LastName' => $value['n_last'],
                'UserName' => $value['username'],
                'Password' => Hash::decrypt($value['password'], $value['ID']),
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
                Shareholder::update(['email-sent' =>  (int)$value['email-sent'] + 1], $value['ID']);
            } catch (\Throwable $th) {
                //throw $th;
            }
        }
        return response()->json([
            'message' => 'sent',
            'status' => true
        ]);
    }


    public function updateData()
    {
        $shareholders = database()->Select("SELECT TOP 100 username,ID FROM EGM WHERE password IS NULL");
        foreach ($shareholders as $key => $value) {
            $password = Hash::encrypt(Hash::randomPassword(),$value['ID']);
            $continue = database()->Run("UPDATE EGM SET password = ?, username = i_holder WHERE password IS NULL AND ID = ?", [$password, $value['ID']]);
        }
        // MOSTAFA_TODO create update many
        return response()->json([
            'message' => __('updated'),
            'status' => true
        ]);
    }


    /* 
    
    */
    public function updateStatus()
    {
        $validator = validator(request()->dataArray(), [
            'status' => ['nullable'],
        ]);


        try {
            $data = $validator->validate();
            $r = Shareholder::update(['status' => (bool)$data['status']], request()->only('ID'));
            return response()->json([
                'message' => __('updated'),
                'status' => true,
                'ss' => $data,
                '$r' => $r
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'errors' => $th->errorsBag
            ], 422);
        }
    }
}
