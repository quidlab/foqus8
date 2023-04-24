<?php

namespace App\Controllers;

use LIB\Request\Request;

class SystemConstantController extends Controller
{





    public function getString()
    {
        $sql = "SELECT * FROM Meeting_Constants_Str where Constant_Type='System' AND Options is NULL ORDER BY ID ";
        $results = $this->DB->Select($sql, []);
        foreach ($results as $row) {
            $output[] = array(
                'ID'    => $row['ID'],
                'Constant_Name'  => $row['Constant_Name'],
                'Constant_Value'   => $row['Constant_Value'],
                'Description'    => $row['Description'],
                "Options" => $row['Options']

            );
        }
        return response()->json($output, 200);
    }


    public function updateString()
    {
        parse_str(file_get_contents("php://input"), $_PUT);
        $sql = "UPDATE Meeting_Constants_Str set Constant_Value = ? where id= ?";
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

    public function getDate()
    {
        $sql = "SELECT * FROM Meeting_Constants_Date where Constant_Type='System' ORDER BY ID ";
        $results = $this->DB->Select($sql, []);
        foreach ($results as $row) {
            $output[] = array(
                'ID'    => $row['ID'],
                'Constant_Name'  => $row['Constant_Name'],
                'Constant_Value'   => $row['Constant_Value']->format('Y-m-d\Th:i:s'),
                'Description'    => $row['Description']
            );
        }

        return response()->json($output, 200);
    }

    /* 
    
    */
    public function updateDate()
    {
        parse_str(file_get_contents("php://input"), $_PUT);
        $sql = "UPDATE Meeting_Constants_Date set Constant_Value = ? where id= ?";
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

    /* 
    
    */
    public function getBool()
    {
        $sql = "SELECT * FROM Meeting_Constants_Bool where Constant_Type='System' ORDER BY ID ";
        $results = $this->DB->Select($sql, []);
        foreach ($results as $row) {
            $output[] = array(
                'ID'    => $row['ID'],
                'Constant_Name'  => $row['Constant_Name'],
                'Constant_Value'   => $row['Constant_Value'],
                'Description'    => $row['Description']
            );
        }

        return response()->json($output, 200);
    }

    /* 
    
    */
    public function updateBool()
    {
        parse_str(file_get_contents("php://input"), $_PUT);
        $sql = "UPDATE Meeting_Constants_Bool set Constant_Value = ? where id= ?";
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


    /* 
    
    */
    public function getNumber()
    {
        $sql = "SELECT * FROM Meeting_Constants_Number where Constant_Type='System' ORDER BY ID ";
        $results = $this->DB->Select($sql, []);
        foreach ($results as $row) {
            $output[] = array(
                'ID'    => $row['ID'],
                'Constant_Name'  => $row['Constant_Name'],
                'Constant_Value'   => $row['Constant_Value'],
                'Description'    => $row['Description']
            );
        }

        return response()->json($output, 200);
    }

    /* 
    
    */
    public function updateNumber()
    {
        parse_str(file_get_contents("php://input"), $_PUT);
        $sql = "UPDATE Meeting_Constants_Number set Constant_Value = ? where id= ?";
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

    /* 
    
    */
    public function getSelect(){
        $sql = "SELECT * FROM Meeting_Constants_Str where Constant_Type='System' AND Options is Not NULL ORDER BY ID ";
        $results = $this->DB->Select($sql, []);
        foreach ($results as $row) {
            $output[] = array(
                'ID'    => $row['ID'],
                'Constant_Name'  => $row['Constant_Name'],
                'Constant_Value'   => $row['Constant_Value'],
                'Description'    => $row['Description'],
                'Options' => $row['Options']

            );
        }
        // print_r($output);die;
        return response()->json($output, 200);
    }
}
