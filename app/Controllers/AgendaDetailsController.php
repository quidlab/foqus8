<?php

namespace App\Controllers;

use LIB\Request\Request;

class AgendaDetailsController extends Controller
{
    public function index()
    {
        if (!isset($_GET['ID'])) {
            $_GET['ID'] = '0';
        }
        $sql = "SELECT * FROM Agendas_Text where AGENDAID=? and Language in ( select Language_ID from Languages where active=1)";
        $params = array($_GET['ID']);
        $results = $this->DB->Select($sql, $params);

        if ($results) {
            foreach ($results as $row) {
                $output[] = array(
                    'ID'    => $row['ID'],
                    'AGENDAID'  => $row['AGENDAID'],
                    'Agenda_Name'   => $row['Agenda_Name'],
                    'Agenda_Info'   => $row['Agenda_Info'],
                    'Approve_Text'    => $row['Approve_Text'],
                    'DisApprove_Text'    => $row['DisApprove_Text'],
                    'Abstain_Text'    => $row['Abstain_Text'],
                    'NoVote_Text'    => $row['NoVote_Text'],
                    'Language'    => $row['Language']
                );
            }
            return response()->json([
                'data' => $output,
                'status' => 1,
            ]);
        } else {
            return response()->json([
                'message' => 'Something went wrong',
                'status' => 0,
            ]);
        }
    }

    /* 
    
    */

    public function update()
    {
        parse_str(file_get_contents("php://input"), $_PUT);
        $sql = "UPDATE Agendas_Text set AGENDAID = ? ,Agenda_Name= ?,Agenda_Info=?,Approve_Text=?,DisApprove_Text=?,Abstain_Text=?,NoVote_Text=? where ID=? ";
        $params = array($_PUT['AGENDAID'], $_PUT['Agenda_Name'], $_PUT['Agenda_Info'], $_PUT['Approve_Text'], $_PUT['DisApprove_Text'], $_PUT['Abstain_Text'], $_PUT['NoVote_Text'], $_PUT['ID']);
        $results = $this->DB->Run($sql, $params);
        if ($results) {
            return response()->json([
                'message' => 'Updated',
                'status' => 1,
            ]);
        } else {
            return response()->json([
                'message' => 'Something went wrong',
                'status' => 0,
            ]);
        }
    }

    /* 
    
    */

    public function truncate(){
        parse_str(file_get_contents("php://input"), $_DELETE);
        $sql="DELETE FROM AGENDAS_TEXT WHERE AGENDAID=?";
        $params=array($_DELETE['ID']);
        $results1 = $this->DB ->Run($sql,$params);
        $sql="DELETE FROM DIRECTORS WHERE Agenda_ID=?";
        $params=array($_DELETE['ID']);
        $results2 = $this->DB ->Run($sql,$params);
        $sql="DELETE FROM AGENDAS WHERE ID=?";
        $params=array($_DELETE['ID']);
        $results3 = $this->DB ->Run($sql,$params);

        if (true) { // TODO Run issue
            return response()->json([
                'message' => 'Updated',
                'status' => 1,
            ]);
        } else {
            return response()->json([
                'message' => 'Something went wrong',
                'status' => 0,
            ]);
        }
    }
}
