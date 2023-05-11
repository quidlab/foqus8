<?php

namespace App\Controllers\API;

use App\Controllers\Controller;

class UploadFilesController extends Controller
{

    public function index()
    {
        $data = database()->Select("SELECT * From [downloads]");
        return response()->json($data);
    }



    public function store()
    {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["file_name"]["name"]);
        if (move_uploaded_file($_FILES["file_name"]["tmp_name"], $target_file)) {
            return response()->json([
                'message' => __('uploaded'),
                'status' => true
            ]);
        } else {
            return response()->json([
                'message' => __('faild'),
                'status' => false
            ]);
        }
    }
}
