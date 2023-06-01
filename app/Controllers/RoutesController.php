<?php

namespace App\Controllers;

use App\Models\Shareholder;
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


    /*
    
    */
    public function egmActivation()
    {
        $egmData2 = "select count(*) as notApproved from EGM where ApprovedForOnline='N'";

        $CountData2 = database()->Select($egmData2);

        $egmData3 = "select count(*) as Approved from EGM where ApprovedForOnline='Y'";
        $CountData3 = database()->Select($egmData3);


        $egmData4 = "select count(*) as totalcount, sum(q_share) as totalvotes from EGM ";
        $CountData4 = database()->Select($egmData4);


        $TotCoowners = $CountData4[0]['totalcount'];
        $TotCoownerVotes = $CountData4[0]['totalvotes'];
        return view('/admin/egm-activation', [
            'CountData2' => $CountData2,
            'CountData3' => $CountData3,
            'CountData4' => $CountData4,
            'TotCoowners' => $TotCoowners,
            'TotCoownerVotes' => $TotCoownerVotes,
        ], '/admin/index');
    }


    /*
    
    */
    public function importShareholders()
    {
        $requiredFields = json_decode(constant('MC_Shreholders_Required_Fields'));
        $egmCount = database()->Select("SELECT count(*) AS total FROM EGM")[0];
        $columns = database()->Select("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS");
        $search_array = array_map('strtolower', array_column($columns, 'COLUMN_NAME'));
        $dif = [];

        foreach (array_column($requiredFields, 'id') as $key => $value) {
            if (!in_array(strtolower($value), $search_array)) {
                $dif[] = $value;
            }
        }


        return view('/admin/import-shareholders', [
            'requiredFields' => $requiredFields,
            'egmCount' => reset($egmCount),
            'notValidColumns' => $dif
        ], '/admin/index');
    }

    /* 
    
    */
    public function ApproveOnlineJoiners()
    {
        return view('/admin/join-online-joiners', [], '/admin/index');
    }



    /* 
        reports
    */
    public function reports()
    {
        return view('/admin/reports', [], '/admin/index');
    }
}
