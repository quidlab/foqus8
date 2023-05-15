<?php

namespace App\Controllers\API;

use App\Controllers\Controller;
use App\Models\Shareholder;
use Lib\Services\Excel\Excel;

class ShareholdersController extends Controller
{

    public function index(){

        return response()->json(database()->Select("SELECT TOP (10) * from EGM"));
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
            foreach ($excel->only(['Account_ID', 'q_share', 'n_title', 'n_first', 'i_ref', 'h_phone', 'i_zip', 'a_holder', 'n_last'],true) as $key => $row) {
                $rows[$key] = $row;
                $rows[$key]['i_holder'] = $row['Account_ID'];
                $rows[$key]['a_holder_1'] = $row['a_holder'];
                $rows[$key]['I_ref'] = $row['i_ref'];
                unset($rows[$key]['Account_ID']);
                unset($rows[$key]['a_holder']);
                unset($rows[$key]['i_ref']);
            }

            $r2 = Shareholder::createMany($rows, Shareholder::readable(), 1000);

            $r3 = database()->Run("UPDATE EGM SET Attended = 'N', Shares_Attended = 0, Proxy = 'N', Proxy_name = '', BallotPaperPrinted = 0, Custodian = 'N', USER_ID = '', Registered_Time = NULL, Out_Time = NULL,org_q_share=q_share,Group_id=NULL,serial=0,coupon1_claimed='N',coupon2_claimed='N',coupon3_claimed='N',feedback_submitted='N',factory_visit_interested='N',org_n_first=n_first,org_n_last=n_last,org_i_ref=I_ref,ProxyType=NULL,e_mail=NULL,m_phone=NULL,username=NULL,password=NULL,ApprovedForOnline='N',IPAddress=NULL,lastlogin=NULL,status=0,active=0,Email_sent='N',doc_received='N',jitsiid='0';");
            return ($r1 && $r2 && $r3);
        });


        return response()->json([
            'status' => $r,
            'message' => __($r ? 'imported' : 'faild')
        ]);
    }
}
