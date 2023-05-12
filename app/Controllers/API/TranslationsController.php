<?php

namespace App\Controllers\API;

use App\Controllers\Controller;

class TranslationsController extends Controller
{
    public function index()
    {
        $modulFilter = '';
        if (key_exists('module',$_GET) && $_GET['module']) {
            if ($_GET['module'] == 'NULL') {
                $modulFilter = "AND Translations.Module IS NULL";
            }else{
                $modulFilter = "AND Translations.Module = '" . $_GET['module'] . "'";
            }
        }
        $data = database()->Select("Select Languages.Language_ID AS Local,Translations.Tname AS ID, Translations.Tvalue AS Value,Translations.Module AS Module from Translations LEFT JOIN Languages On Languages.Language_ID = Translations.Tlang Where Languages.Active = 1 ".$modulFilter." Group By Language_ID,Translations.Tvalue,Translations.Tname,Translations.Module");
        $words = [];
        foreach ($data as $key => $row) {
            $words[$row['ID']]['Key'] = $row['ID'];
            $words[$row['ID']]['Value_' . $row['Local']] = $row['Value'];
            $words[$row['ID']]['Module'] = $row['Module'];
        }
        $words2 = [];
        foreach ($words as $key => $row) {
            $words2[] = $row;
        }

        return response()->json($words2, 200);
    }


    /* 
    
    */
    public function update()
    {
        parse_str(file_get_contents("php://input"), $_PUT);

        $rows = [];
        foreach ($_PUT as $key => $value) {
            if (strstr($key, "Value")) {
                $rows[$key]['lang'] = substr($key, 6);
                $rows[$key]['value'] = $value;
                $rows[$key]['key'] = $_PUT['Key'];
            }
        }

        foreach ($rows as $key => $row) {
            $stmt = "UPDATE Translations set Tvalue = ? where Tlang= ? AND Tname = ?";
            $params = [$row['value'], $row['lang'], $row['key']];
            $result = $this->DB->Run($stmt, $params);
        }

        if ($result) {
            return response()->json([
                'status' => 1,
                'message' => 'Updated'
            ]);
        } else {
            return response()->json([
                'status' => 0,
                'message' => 'Some thing went wrong'
            ]);
        }
    } // there is one problem with update is that if a new language added or become active the translation row for this language will be missing ,
    // so we need to check first if that row is exists or not and if not we create it,
    // second option to disable edit and the user can delete old key values and create new 


    /* 
    
    */
    public function store()
    {

        $rows = [];
        foreach ($_POST as $key => $value) {
            if (strstr($key, "Value")) {
                $rows[$key]['lang'] = substr($key, 6);
                $rows[$key]['value'] = $value;
                $rows[$key]['key'] = $_POST['Key'];
            }
        }

        foreach ($rows as $key => $row) {
            $stmt = "INSERT INTO Translations (Tvalue,Tlang,Tname) VALUES  (?,?,?)";
            $params = [$row['value'], $row['lang'], $row['key']];
            $result = $this->DB->Run($stmt, $params);
        }


        if ($result) {
            logger()->info("Added new translation.  User_ID: " . session('uname'). " IP ADDRESS: " . app()->getUserIP() . " Time:" . date('Y-m-d H:i:s'));
            return response()->json([
                'status' => 1,
                'message' => 'Created'
            ]);
        } else {
            logger()->info("Faild to add new translation.  User_ID: " . session('uname'). " IP ADDRESS: " . app()->getUserIP() . " Time:" . date('Y-m-d H:i:s'));
            return response()->json([
                'status' => 0,
                'message' => 'Some thing went wrong'
            ]);
        }
    }




    /* 
    
    */

    public function truncate()
    {
        parse_str(file_get_contents("php://input"), $_DELETE);

        $stmt = "DELETE FROM Translations Where Tname = ?";
        $params = [$_DELETE['Key']];
        $result = $this->DB->Run($stmt, $params);
        if ($result) {
            logger()->info("Deleted translation.  User_ID: " . session('uname'). " IP ADDRESS: " . app()->getUserIP() . " Time:" . date('Y-m-d H:i:s'));
            return response()->json([
                'status' => 1,
                'message' => 'Deleted'
            ]);
        } else {
            logger()->info("Faild To Delete translation.  User_ID: " . session('uname'). " IP ADDRESS: " . app()->getUserIP() . " Time:" . date('Y-m-d H:i:s'));
            return response()->json([
                'status' => 0,
                'message' => 'Some thing went wrong'
            ]);
        }
    }
}
