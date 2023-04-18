<?php

namespace App\Controllers;

use LIB\Request\Request;

class AgendaController extends Controller
{


    public function index()
    {
        $sql = "SELECT * FROM Agendas ORDER BY Sort_ID ";
        $results = $this->DB->Select($sql, []);
        if ($results) {
            foreach ($results as $row) {

                $output[] = array(
                    'ID'    => $row['ID'],
                    'Sort_ID'  => $row['Sort_ID'],
                    'AGENDA_ID'   => $row['AGENDA_ID'],
                    'Special_Formula'    => $row['Special_Formula'],
                    'Voting_Required'    => $row['Voting_Required'],
                    'Reverse_Vote'    => $row['Reverse_Vote'],
                    'Approval_Percent'    => $row['Approval_Percent'],
                    'NumberOfDirectorsToEleect'    => $row['NumberOfDirectorsToEleect'],
                    'Voting_Started'    => $row['Voting_Started'],
                    'Percent_Based_On_FullShares'    => $row['Percent_Based_On_FullShares']
                );
            }

            return response()->json([
                'status' => 1,
                'data' => $output
            ]);
        } else {


            return response()->json([
                'status' => 0,
                'data' => null
            ]);
        }
    }




    public function store()
    {
        $request = new Request();

        $result = $this->DB->transaction(function () {
            $sql = "INSERT INTO Agendas (Sort_ID, AGENDA_ID,Special_Formula,Voting_Required,Reverse_Vote,Approval_Percent,NumberOfDirectorsToEleect,Voting_Started,Percent_Based_On_FullShares  ) Values( ?,?,?,?,?,?,?,?,?) ;";

            $params = array($_POST['Sort_ID'], $_POST['AGENDA_ID'], $_POST['Special_Formula'], $_POST['Voting_Required'], $_POST['Reverse_Vote'], $_POST['Approval_Percent'], $_POST['NumberOfDirectorsToEleect'], $_POST['Voting_Started'], $_POST['Percent_Based_On_FullShares']);
            $pk = $this->DB->InsertAndGetPK($sql, $params);
            print_r($this->storeAgendaTexts($pk));
            $agendaTextsResults = $this->storeAgendaTexts($pk);

            $directorsResults = [1];
            if ($_POST['Voting_Required'] == 'C' || $_POST['Voting_Required'] == 'S') {
                $directorsResults = $this->storeDirerctors($pk);
            }
            return $directorsResults;
            return ((count(array_intersect([1], $agendaTextsResults)) === count($agendaTextsResults)) && (count(array_intersect([1], $directorsResults)) === count($directorsResults)));
        });


        if ($result) {
            return $request->back()->withMessage('Created');
        } else {
            return $request->back()->withMessage('Something went wrong');
        }
    }


    public function update()
    {
        parse_str(file_get_contents("php://input"), $_PUT);
        $sql = "UPDATE Agendas set Sort_ID = ? ,AGENDA_ID= ?,Special_Formula=?,Voting_Required=?,Reverse_Vote=?,Approval_Percent=?,NumberOfDirectorsToEleect=?,Voting_Started=?,Percent_Based_On_FullShares=? where ID=? ";
        $params = array($_PUT['Sort_ID'], $_PUT['AGENDA_ID'], $_PUT['Special_Formula'], $_PUT['Voting_Required'], $_PUT['Reverse_Vote'], $_PUT['Approval_Percent'], $_PUT['NumberOfDirectorsToEleect'], $_PUT['Voting_Started'], $_PUT['Percent_Based_On_FullShares'], $_PUT['ID']);
        $results = $this->DB->Run($sql, $params);



        if ($results) {
            return response()->json([
                'status' => 1,
                'message' => 'Updated'
            ]);
        } else {


            return response()->json([
                'status' => 0,
                'message' => 'Something went wrong'
            ]);
        }
    }


    public function truncate()
    {
        parse_str(file_get_contents("php://input"), $_DELETE);

        $sql = "DELETE FROM AGENDAS_TEXT WHERE AGENDAID=?";
        $params = array($_DELETE['ID']);
        $results1 = $this->DB->Run($sql, $params);
        $sql = "DELETE FROM DIRECTORS WHERE Agenda_ID=?";
        $params = array($_DELETE['ID']);
        $results2 = $this->DB->Run($sql, $params);
        $sql = "DELETE FROM AGENDAS WHERE ID=?";
        $params = array($_DELETE['ID']);
        $results3 = $this->DB->Run($sql, $params);


        if (/* $results1 && $results2 && $results3 */true) { // TODO same problem for Run method rerturn value (affected rows count)
            return response()->json([
                'status' => 1,
                'message' => 'Deleted'
            ]);
        } else {


            return response()->json([
                'status' => 0,
                'message' => 'Something went wrong'
            ]);
        }
    }





    protected function storeAgendaTexts($agendaID)
    {
        $results = [];
        foreach ($this->agendaTextFormatter() as $key => $value) {
            $sql = "INSERT INTO Agendas_Text (AGENDAID,Agenda_Name,Agenda_Info,Language,Approve_Text,DisApprove_Text,Abstain_Text,NoVote_Text,VoidText) VALUES (?,?,?,?,?,?,?,?,?)";
            $results[] = $this->DB->Run($sql, [
                $agendaID,
                $value[0],
                $value[1],
                $value[2],
                $value[3],
                $value[4],
                $value[5],
                $value[6],
                $value[7]
            ]);
        }
        return $results;
    }

    protected function storeDirerctors($agendaID)
    {
        $results = [];
        foreach ($this->directorsFormatter() as $key => $value) {
            $sql = "INSERT INTO Directors (Agenda_ID,Director_Name ,Director_ID,Language) VALUES (?,?,?,?)";
            $results[] = $this->DB->Run($sql, [
                $agendaID,
                $value['name'],
                $value['id'],
                $value['lang'],
            ]);
        }
        return $results;
    }

    protected function agendaTextFormatter()
    {
        $agendaTexts = [];
        foreach ($_POST as $key => $value) {
            if (strstr($key, "agenda_text")) {
                $index =  substr($key, 12, 1);
                $agendaTexts[$index][] = $value;
            }
        }

        return $agendaTexts;
    }
    protected function directorsFormatter()
    {
        $directors = [];
        foreach ($_POST as $key => $value) {
            if (strstr($key, "director")) {
                $index =  substr($key, 9, 1);
                if (explode('-',$key)[2] == 'id') {
                    $id = $value;
                }
                if (explode('-',$key)[2] == 'name') {
                    $directors[explode('-',$key)[1]]['id'] = $id;
                    $directors[explode('-',$key)[1]][explode('-',$key)[3]] = $value;
                }
            
            }
        }
        $out = [];
        $inx2 = 0;
        foreach ($directors as $key => $director) {
            $inx = 0;
            foreach ($director as $key2 => $value) {
                $arr = [];
                if ($key2 != 'id') {
                    $out[$inx . $inx2]['lang'] = $key2;
                    $out[$inx . $inx2]['name'] = $value;
                    $out[$inx . $inx2]['id'] = $director['id'];
                    $inx++;
                }
            }
            $inx2++;

        }
        return $out;
    }
}
