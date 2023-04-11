<?php

namespace App\Controllers;

use LIB\Request\Request;

class CompanyController extends Controller
{

    public function getAll()
    {
        $sql = "SELECT * FROM company WHERE  Tlang in ( SELECT Language_ID FROM languages WHERE Active=1 ) ORDER BY ID ";
        //echo $query;
        //$results = $FoQusdatabase -> get_results($query ,'array');
        $params = array();
        $results = $this->DB->Select($sql, $params);
        foreach ($results as $row) {
            $output[] = array(
                'ID'    => $row['ID'],
                'Company_Name'  => $row['Company_Name'],
                'Meeting_Place'   => $row['Meeting_Place'],
                'Tlang'    => $row['Tlang']

            );
        }
        header("Content-Type: application/json");
        echo json_encode($results);
    }




    public function update(){
        parse_str(file_get_contents("php://input"), $_PUT);
        $sql= "UPDATE Company set Company_Name = ?, Meeting_Place = ? where id= ?";
        $params=array($_PUT['Company_Name'],$_PUT['Meeting_Place'],$_PUT['ID']);
        $results = $this->DB->Run($sql,$params);
        if ($results) {
            return response()->json([
                'message' => 'Updated',
                'status' => 1
            ]);
        }else{
            return response()->json([
                'message' => 'Something went wrong',
                'status' => 0
            ]);
        }
    }
}
