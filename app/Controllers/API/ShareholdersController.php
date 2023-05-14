<?php

namespace App\Controllers\API;

use App\Controllers\Controller;
use App\Models\Shareholder;
use Lib\Services\Excel\Excel;

class ShareholdersController extends Controller
{





    /* 
    
    */
    public function import()
    {
        $excel = Excel::import('file_name');

        $r = database()->transaction(function () use ($excel) {
            $sql = "DELETE FROM AgendaResults;Delete from EGM;DBCC CHECKIDENT ('EGM', RESEED, 11111110);";
            $r1 = database()->Run($sql);

            $r2 = Shareholder::createMany($excel->rows(), Shareholder::readable(), 1000);
            return ($r1 && $r2);
        });


        return response()->json([
            'status' => $r,
            'message' => __($r ? 'imported' : 'faild')
        ]);
    }
}
