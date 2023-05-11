<?php

namespace App\Controllers;

use LIB\Request\Request;

class RoutesController extends Controller
{
    public function adminTools()
    {
        $sql = "SELECT (SELECT COUNT(*) from egm)  AS TotalShareHolders , ( select sum(q_share) from egm )  as TotalShares , (select count(*) from egm  where approvedforonline = 'Y' ) as TotalApprovedForOnline , (select sum(q_share) from egm where approvedforonline=  'Y' ) as SharesApprovedforOnline , ( select count(*) from egm where doc_received= 'Y' ) as TotalDocumentRegistred , (SELECT sum(q_share) from egm where doc_received= 'Y') as TotalDocumentRegistredShares , ( select count(*) from egm where doc_received= 'Y' and ApprovedForOnline<>'Y' ) as ShareholdersStillToApprove , (SELECT sum(q_share) from egm where doc_received= 'Y' and ApprovedForOnline<>'Y') as TotalSharesStillToApprove";
        //$DashboardInfo = $FoQusdatabase -> get_row($sql ,'array');
        /*         $params = array();
        $DashboardInfo = $this->DB->Select($sql, $params);
 */

        return view('/admin/admin-tools', [], '/admin/index');
    }




    public function manageCompany()
    {
        return view('/admin/manage-company', [], '/admin/index');
    }


    public function systemConstants()
    {
        return view('/admin/constants/system-constants', [], '/admin/index');
    }
    public function agendas()
    {
        return view('/admin/agendas/agendas', [], '/admin/index');
    }


    /* 
    
    */
    public function createAgenda()
    {
        return view('/admin/agendas/create', [], '/admin/index');
    }

    public function createAgenda2()
    {
        return view('/admin/agendas/create2', [], '/admin/index');
    }

    public function translations()
    {
        return view('/admin/translations', [], '/admin/index');
    }


    public function users()
    {
        return view('/admin/users/index', [], '/admin/index');
    }

    /*
    
    */
    public function presenters()
    {
        return view('/admin/presenters/index', [], '/admin/index');
    }

    /*
    
    */
    public function uploadFiles()
    {
        return view('/admin/upload-files', [], '/admin/index');
    }

    /*
    
    */
    public function stakeholders()
    {
        $agendas = database()->Select("SELECT ID,AGENDA_ID FROM AGENDAS");
        return view('/admin/stakeholders', [
            'agendas' => $agendas
        ], '/admin/index');
    }


    /*
    
    */
    public function proxyNames()
    {
        return view('/admin/proxy-names', [], '/admin/index');
    }

    /*
    
    */
    public function coupons()
    {
        return view('/admin/coupons', [], '/admin/index');
    }
}
