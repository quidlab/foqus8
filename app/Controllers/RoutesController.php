<?php

namespace App\Controllers;

use LIB\Request\Request;

class RoutesController extends Controller
{
    public function adminTools()
    {
        $sql = "SELECT (SELECT COUNT(*) from egm)  AS TotalShareHolders , ( select sum(q_share) from egm )  as TotalShares , (select count(*) from egm  where approvedforonline = 'Y' ) as TotalApprovedForOnline , (select sum(q_share) from egm where approvedforonline=  'Y' ) as SharesApprovedforOnline , ( select count(*) from egm where doc_received= 'Y' ) as TotalDocumentRegistred , (SELECT sum(q_share) from egm where doc_received= 'Y') as TotalDocumentRegistredShares , ( select count(*) from egm where doc_received= 'Y' and ApprovedForOnline<>'Y' ) as ShareholdersStillToApprove , (SELECT sum(q_share) from egm where doc_received= 'Y' and ApprovedForOnline<>'Y') as TotalSharesStillToApprove";
        //$DashboardInfo = $FoQusdatabase -> get_row($sql ,'array');
        $params = array();
        $DashboardInfo = $this->DB->Select($sql, $params);

        $sql = "select Language_Name, Language_ID, Flag_ID from Languages where Active=?";
        $languages = $this->DB->Select($sql, ['1']);

        $sql = 'select Company_Name,Meeting_Place from Company where Tlang =' . "'" . $this->app->local . "'";
        $company_name = $this->DB->Select($sql);
        return view('/admin/admin-tools', [
            'company_name' => $company_name,
            'languages'=>$languages
        ], '/admin/index');
    }




    public function manageCompany()
    {
        $sql = 'select Company_Name,Meeting_Place from Company where Tlang =' . "'" . $this->app->local . "'";
        $company_name = $this->DB->Select($sql);

        $sql = "select Language_Name, Language_ID, Flag_ID from Languages where Active=?";
        $languages = $this->DB->Select($sql, ['1']);

        return view('/admin/manage-company', ['company_name' => $company_name,'languages'=>$languages], '/admin/index');
    }



    public function meetingConstants()
    {
        $sql = 'select Company_Name,Meeting_Place from Company where Tlang =' . "'" . $this->app->local . "'";
        $company_name = $this->DB->Select($sql);

        $sql = "select Language_Name, Language_ID, Flag_ID from Languages where Active=?";
        $languages = $this->DB->Select($sql, ['1']);

        return view('/admin/constants/meeting-constants', ['company_name' => $company_name,'languages'=>$languages], '/admin/index');
    }


    public function systemConstants()
    {
        $sql = 'select Company_Name,Meeting_Place from Company where Tlang =' . "'" . $this->app->local . "'";
        $company_name = $this->DB->Select($sql);

        $sql = "select Language_Name, Language_ID, Flag_ID from Languages where Active=?";
        $languages = $this->DB->Select($sql, ['1']);

        return view('/admin/constants/system-constants', ['company_name' => $company_name,'languages'=>$languages], '/admin/index');


    }
    public function agendas()
    {
        $sql = 'select Company_Name,Meeting_Place from Company where Tlang =' . "'" . $this->app->local . "'";
        $company_name = $this->DB->Select($sql);

        $sql = "select Language_Name, Language_ID, Flag_ID from Languages where Active=?";
        $languages = $this->DB->Select($sql, ['1']);

        return view('/admin/agendas/agendas', ['company_name' => $company_name,'languages'=>$languages], '/admin/index');
    }


    /* 
    
    */
    public function createAgenda()
    {
        $sql = 'select Company_Name,Meeting_Place from Company where Tlang =' . "'" . $this->app->local . "'";
        $company_name = $this->DB->Select($sql);

        $sql = "select Language_Name, Language_ID, Flag_ID from Languages where Active=?";
        $languages = $this->DB->Select($sql, ['1']);

        return view('/admin/agendas/create', ['company_name' => $company_name,'languages'=>$languages], '/admin/index');
    }
}
