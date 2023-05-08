<?php

namespace App\Controllers;

use LIB\Request\Request;

class ConstantController extends Controller
{



    public function meetingIndex()
    {
        $sql = "SELECT * FROM Meeting_Constants_Str where Constant_Type='Meeting' AND Options is NULL ORDER BY ID ";
        $params = array();
        $results = $this->DB->Select($sql, $params);
        foreach ($results as $row) {
            $output[] = array(
                'ID'    => $row['ID'],
                'Constant_Name'  => $row['Constant_Name'],
                'Constant_Value'   => $row['Constant_Value'],
                'Description'    => $row['Description'],
                'Options' => $row['Options']?json_decode($row['Options']):null

            );
        }

        return response()->json($output, 200);
    }


    public function meetingUpdate()
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



    public function dateConstants()
    {
        $sql = "SELECT * FROM Meeting_Constants_Date where Constant_Type='Meeting' ORDER BY ID ";
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
    public function dateUpdate()
    {
        parse_str(file_get_contents("php://input"), $_PUT);
        $sql = "UPDATE Meeting_Constants_Date set Constant_Value = ? where id= ?";
        $params = array($_PUT['Constant_Value'], $_PUT['ID']);
        $results = $this->DB->Run($sql, $params);


        if ($results) {
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
    }


    /* 
    
    */
    public function boolConstants()
    {



        $sql = "SELECT * FROM Meeting_Constants_Bool where Constant_Type='Meeting' ORDER BY ID ";
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
    public function boolUpdate()
    {

        parse_str(file_get_contents("php://input"), $_PUT);
        $sql = "UPDATE Meeting_Constants_Bool set Constant_Value = ? where id= ?";
        $params = array($_PUT['Constant_Value'], $_PUT['ID']);
        $results = $this->DB->Run($sql, $params);

        if ($results) {
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
    }


    /* 
    
    */
    public function intConstants()
    {



        $sql = "SELECT * FROM Meeting_Constants_Number where Constant_Type='Meeting' ORDER BY ID ";
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
    public function intUpdate()
    {

        parse_str(file_get_contents("php://input"), $_PUT);
        $sql = "UPDATE Meeting_Constants_Number set Constant_Value = ? where id= ?";
        $params = array($_PUT['Constant_Value'], $_PUT['ID']);
        $results = $this->DB->Run($sql, $params);

        if ($results) {
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
    }

    /* 
    
    */

    public function getSelect(){
        $sql = "SELECT * FROM Meeting_Constants_Str where Constant_Type='Meeting' AND Options is Not NULL ORDER BY ID ";
        $results = $this->DB->Select($sql, []);
        if ($results) {
            foreach ($results as $row) {
                $output[] = array(
                    'ID'    => $row['ID'],
                    'Constant_Name'  => $row['Constant_Name'],
                    'Constant_Value'   => $row['Constant_Value'],
                    'Description'    => $row['Description'],
                    'Options' => $row['Options']
    
                );
            }
        }else{
            $output = [];
        }
        // print_r($output);die;
        return response()->json($output, 200);
    }


    /* 
    
    */
/*     public function updateSelect()
    {
        parse_str(file_get_contents("php://input"), $_PUT);
        $sql = "UPDATE Meeting_Constants_Str set Constant_Value = ? where id= ?";
        $params = array(json_encode($_PUT['Constant_Value']), $_PUT['ID']);
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
    } */
}
