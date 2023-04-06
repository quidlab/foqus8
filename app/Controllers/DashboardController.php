<?php

namespace App\Controllers;

use LIB\Request\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $sql = "SELECT (SELECT COUNT(*) from egm)  AS TotalShareHolders , ( select sum(q_share) from egm )  as TotalShares , (select count(*) from egm  where approvedforonline = 'Y' ) as TotalApprovedForOnline , (select sum(q_share) from egm where approvedforonline=  'Y' ) as SharesApprovedforOnline , ( select count(*) from egm where doc_received= 'Y' ) as TotalDocumentRegistred , (SELECT sum(q_share) from egm where doc_received= 'Y') as TotalDocumentRegistredShares , ( select count(*) from egm where doc_received= 'Y' and ApprovedForOnline<>'Y' ) as ShareholdersStillToApprove , (SELECT sum(q_share) from egm where doc_received= 'Y' and ApprovedForOnline<>'Y') as TotalSharesStillToApprove";
        //$DashboardInfo = $FoQusdatabase -> get_row($sql ,'array');
        $params = array();
        $DashboardInfo = $this->DB->Select($sql, $params);

        $sql = "select Language_Name, Language_ID, Flag_ID from Languages where Active=?";
        $params = array('1');
        $languages = $this->DB->Select($sql, $params);

        $sql = 'select Company_Name,Meeting_Place from Company where Tlang =' . "'" . 'en' . "'";
        $params = array();
        $company_name = $this->DB->Select($sql, $params);
        return view('/admin/dashboard', [
            'DashboardInfo' => $DashboardInfo,
            'languages' => $languages,
            'company_name' => $company_name
        ]);
    }
}
