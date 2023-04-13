<?php

namespace App\Controllers;

class DirectorController extends Controller
{
    public function index()
    {
        if (!isset($_GET['Agenda_ID'])) {
            $_GET['Agenda_ID'] = '0';
        }

        $sql = "SELECT * FROM Directors where Agenda_ID=? and Language in ( select Language_ID from Languages where active=1)";
        $params = array($_GET['Agenda_ID']);
        $results = $this->DB->Select($sql, $params);

        if ($results) {
            foreach ($results as $row) {
                $output[] = array(
                    'ID'    => $row['ID'],
                    'Agenda_ID'  => $row['Agenda_ID'],
                    'Director_ID'   => $row['Director_ID'],
                    'Director_Name'    => $row['Director_Name'],
                    'Language'    => $row['Language']
                );
            }
            return response()->json([
                'data' =>  $output,
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

    public function store()
    {
        $sql = "INSERT INTO Agendas (Sort_ID, Agenda_ID,Special_Formula,Voting_Required,Reverse_Vote,Approval_Percent,NumberOfDirectorsToEleect,Voting_Started,Percent_Based_On_FullShares  ) Values( ?,?,?,?,?,?,?,?,?,?  ) ";
        $params = array($_POST['Sort_ID'], $_POST['Agenda_ID'], $_POST['Special_Formula'], $_POST['Voting_Required'], $_POST['Reverse_Vote'], $_POST['Approval_Percent'], $_POST['NumberOfDirectorsToEleect'], $_POST['Voting_Started'], $_POST['Percent_Based_On_FullShares']);
        $results = $this->DB->Run($sql, $params);

        if ($results) {
            return response()->json([
                'message' =>  'Created',
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
        $sql = "UPDATE Directors set Director_Name=? where ID=? ";
        $params = array($_PUT['Director_Name'], $_PUT['ID']);
        $results = $this->DB->Run($sql, $params);
        if ($results) {
            return response()->json([
                'message' =>  'Created',
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

    public function truncate(){ // TODO NOTWORKING ASK
        
        parse_str(file_get_contents("php://input"), $_DELETE); 
        $sql="DELETE FROM Directors WHERE AGENDAID=?";
        $params=array($_DELETE['ID']);
        $results = $this->DB->Run($sql,$params);

        if ($results) {
            return response()->json([
                'message' =>  'Deleted',
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
