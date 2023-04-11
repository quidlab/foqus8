<?php

namespace App\Controllers;

use LIB\Request\Request;

class ConstantController extends Controller
{



    public function meetingIndex()
    {
        $sql = "SELECT * FROM Meeting_Constants where Constant_Type='Meeting' ORDER BY ID ";
        $params = array();
        $results = $this->DB->Select($sql, $params);
        foreach ($results as $row) {
            $output[] = array(
                'ID'    => $row['ID'],
                'Constant_Name'  => $row['Constant_Name'],
                'Constant_Value'   => $row['Constant_Value'],
                'Description'    => $row['Description']

            );
        }

        return response()->json($results, 200, [
            "Content-Type: application/json"
        ]);
    }


    public function meetingUpdate()
    {
        parse_str(file_get_contents("php://input"), $_PUT);
        $sql = "UPDATE Meeting_Constants set Constant_Value = ? where id= ?";
        $params = array($_PUT['Constant_Value'], $_PUT['ID']);
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


    public function systemIndex()
    {
        $sql = "SELECT * FROM Meeting_Constants where Constant_Type='System' ORDER BY ID ";
        $results = $this->DB->Select($sql, []);
        foreach ($results as $row) {
            $output[] = array(
                'ID'    => $row['ID'],
                'Constant_Name'  => $row['Constant_Name'],
                'Constant_Value'   => $row['Constant_Value'],
                'Description'    => $row['Description']

            );
        }

        return response()->json($results, 200);
    }


    public function systemUpdate()
    {
        parse_str(file_get_contents("php://input"), $_PUT);
        $sql= "UPDATE Meeting_Constants set Constant_Value = ? where id= ?";
        $params=array($_PUT['Constant_Value'],$_PUT['ID']);
        $results = $this->DB->Run($sql,$params);
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
}
