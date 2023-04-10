<?php

namespace App\Controllers;

use LIB\Request\Request;
use LIB\Router\Router;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class DatabaseController extends Controller
{
    public function truncate()
    {
      
        $SelectMeetingInfo = "SELECT TOP(1) SYMBOL + 'Log_'+ CONVERT(nvarchar,login_allowed_time,6) as uploadfolder from Co_info";
        $FetchInfo = $this->DB->Select($SelectMeetingInfo)[0];
        // print_r($FetchInfo);return;
        $SYMBOLLog = $FetchInfo['uploadfolder'];
        $doc_root = $_SERVER["DOCUMENT_ROOT"];
        $uploads_dir_Log = $doc_root . '/uploads/' . $SYMBOLLog . "/";

        $logger = new Logger('Admin');
        $logger->pushHandler(new StreamHandler($uploads_dir_Log . '/adminlog.log', Logger::DEBUG));

        $ipaddress = $this->app->getUserIP();
        mb_internal_encoding("UTF-8");

        $status = false;
        $message = "ERROR !";
        
        if ($this->realTruncate()) { // realTruncate should be a method of DB Model(class)
            $status = true;
            $message = "Test Data is removed successfully.";
            $logger->Info('Test Data Deleted ', ['user' => $_SESSION['uname'], 'IP' => $ipaddress]);
        }

        $value = array(
            "message" => $message,
            "status" => $status
        );

        $loginDetails = json_encode($value);

        // TODO use Response instance       

        echo ($loginDetails);
        return;

    }

    protected function realTruncate()
    {
        $query = "DELETE FROM AgendaResults";
        
        $execute =  $this->DB->Run($query,[]);
        
        

        $query1 = "UPDATE EGM SET q_share = org_q_share,n_first=org_n_first,n_last=org_n_last,I_ref=org_i_ref";
        $execute1 = $this->DB->Run($query1,[]);

        $query2 = "UPDATE EGM SET Attended = 'N', Shares_Attended = 0, Proxy = 'N', Proxy_name = '', BallotPaperPrinted = 0, Custodian = 'N', USER_ID = '', Registered_Time = NULL, Out_Time = NULL,org_q_share=q_share,Group_id=NULL,serial=0,coupon1_claimed='N',coupon2_claimed='N',coupon3_claimed='N',feedback_submitted='N',factory_visit_interested='N',org_n_first=n_first,org_n_last=n_last,org_i_ref=I_ref,ProxyType=NULL";
        $execute2 = $this->DB->Run($query2,[]);

        $query3 = "UPDATE EGM SET e_mail=NULL,m_phone=NULL,username=NULL,password=NULL,ApprovedForOnline='N',IPAddress=NULL,lastlogin=NULL,status=0,active=0,Email_sent='N',doc_received='N',jitsiid='0'";
        $execute3 = $this->DB->Run($query3,[]);

        $query4 = "DELETE FROM quorums";
        $execute4 = $this->DB->Run($query4,[]);

        $query5 = "UPDATE AGENDAS SET Agenda_Completed = 'N', Agenda_Completed_Time = NULL";
        $execute5 =  $this->DB->Run($query5,[]);

        $query6 = "UPDATE Co_info SET Last_group_number='0'";
        $execute6 =  $this->DB->Run($query6,[]);

        $query7 = "Truncate table ques_ans";
        $execute7 =  $this->DB->Run($query7,[]);

        $query8 = "TRUNCATE TABLE LOGINLOG";
        $execute8 = $this->DB->Run($query8,[]);

        $query9 = "TRUNCATE TABLE registrationlog";
        $execute9 = $this->DB->Run($query9,[]);

            /*        echo $execute;
        echo '/';
        echo $execute1;
        echo '/';
        echo $execute2;
        echo '/';
        echo $execute3;
        echo '/';
        echo $execute4;
        echo '/';
        echo $execute5;
        echo '/';
        echo $execute6;
        echo '/';
        echo $execute7;
        echo '/';
        echo $execute8;
        echo '/';
        echo $execute9;
        echo '/'; */

        return true;
        return ($execute && $execute1 && $execute2 && $execute3 && $execute4 && $execute5 && $execute6 && $execute7 && $execute8 && $execute9);
        // QUESTION ASK TODO => SQLSRV_DataBase class return false if the number of affected == 0 , 
        // 1- we can create a method similar to the Run method that returns the result instead of rows affected
    }
}
