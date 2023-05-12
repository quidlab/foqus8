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



    static function export(){
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'First_Name');
        $sheet->setCellValue('B1', 'Last_Name');
        $sheet->setCellValue('C1', 'Email');
        $sheet->setCellValue('D1', 'DOB');
        $sheet->setCellValue('E1', 'Contact_No');
        $writer = new XlsxWriter($spreadsheet);
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
}
