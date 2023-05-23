<?php

namespace Lib\Services\Excel;

use App\Exceptions\ValidationException;
use Exception;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as XlsxReader;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as XlsxWriter;

class Excel
{
    protected static $mimes = [
        'text/xls', 'text/xlsx', 'application/excel', 'application/vnd.msexcel', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
    ];
    protected $reader;
    protected Spreadsheet $spreadsheet;
    protected $hasHeaders = true;
    public function __construct()
    {
        $this->reader = new XlsxReader();
    }

    static function import(string $fileName)
    {

        if (!empty($_FILES[$fileName]['name'])) {
            if (in_array($_FILES[$fileName]['type'], self::$mimes)) {
                $file = new self;
                $file->spreadsheet = $file->reader->load($_FILES[$fileName]['tmp_name']);
                return $file;
            } else {
                throw new Exception("File mime (type) is not acceptable ");
            }
        } else {
            throw new Exception("File Not Found");
        }
    }

    /*
    
    */
    public function rows()
    {
        return $this->prepareRows();
    }

    /*
    
    */
    public function only(array $keys, $restriction = false) // MOSTAFA_TODO MODIFY
    {
        $sheet =  $this->spreadsheet->getActiveSheet()->toArray();
        $headers = $this->getHeaders();


        /*  */
        $indexes = [];
        foreach ($keys as $key => $value) {
            if ($inx = array_search($value, $headers)) {
                $indexes[] = $inx;
            }else if($restriction){
                throw new Exception($value . " Is Required");
            }
        }

        /*  */
        $rows = [];
        foreach ($sheet as $key => $row) {
            if ($key == 0) {
                continue;
            }

            $rows[$key] = [];
            foreach ($indexes as $key2 => $inx) {
                $rows[$key][$headers[$inx]] = $row[$inx];
            }
        }

        return $rows;
    }
    // array_intersect_key

    /* 
    
    */
    protected function prepareRows()
    {
        $sheet =  $this->spreadsheet->getActiveSheet()->toArray();
        $headers = $sheet[0];
        $rows = [];
        foreach ($sheet as $key => $row) {
            if ($key != 0) {
                $rows[$key] = [];
                foreach ($row as $key2 => $cell) {
                    $rows[$key][$headers[$key2]] = $cell;
                }
            }
        }

        return $rows;
    }



    static function export(array $headers, array $data,$name = "output")
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $col = 1;
        foreach ($headers as $header) {
            $row = 1;
            $sheet->setCellValue([$col, $row], $header);
            foreach ($data as $key => $value) {
                $row++;
                if (key_exists($header, $value)) {
                    $sheet->setCellValue([$col, $row], $value[$header]);
                } else {
                    throw new Exception($header . " Not Exist In Array");
                }
            }
            $col++;
        }
        $writer = new XlsxWriter($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename='.$name.'.xlsx');
        $writer->save('php://output');
        return $writer;
    }


    /* 
    
    */
    /*     public function validate(array $rules)
    {
        $data = [];
        foreach ($this->rows() as $key => $row) {
            try {
                $data[] = validator($row, $rules)->validate();
            } catch (ValidationException $th) {
                throw $th;
            }
        }
        return $data;
    } */


    public function getHeaders()
    {
        $sheet =  $this->spreadsheet->getActiveSheet()->toArray();
        return $sheet[0];
    }
}
