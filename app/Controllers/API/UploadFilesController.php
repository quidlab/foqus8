<?php

namespace App\Controllers\API;

use App\Controllers\Controller;
use App\Exceptions\ValidationException;
use Lib\File\File;

class UploadFilesController extends Controller
{

    public function index()
    {
        $data = database()->Select("SELECT * From [downloads]");
        return response()->json($data);
    }



    /* 
    
    */
    public function store()
    {
        $validator = validator($_POST, [
            'description' => ['required'],
            'language' => ['required'],
        ]);
        $data = $validator->validate();

        $path = File::storePublic("file_name", "uploaded_files");
        if (!$path) {
            return response()->json([
                'message' => __('faild'),
                'status' => false
            ]);
        };

        $result = database()->Run(
            "INSERT INTO [downloads] (file_name,language,description) VALUES (?,?,?)",
            [$path, $data['language'], $data['description']]
        );



        if ($result) {
            return response()->json([
                'message' => __('created'),
                'status' => true
            ]);
        } else {
            return response()->json([
                'message' => __('faild'),
                'status' => false
            ]);
        }
    }


    /* 
    
    */
    public function update()
    {
        $validator = validator($_POST, [
            'id' => ['required'],
            'description' => ['required'],
            'language' => ['required'],
        ]);
        $data = $validator->validate();
        $fileStr = "";

        if (isset($_FILES['file_name'])) {
            $path = File::storePublic("file_name", "uploaded_files");
            $fileStr = "file_name = '$path' ,";
        }

        $result = database()->Run(
            "UPDATE downloads SET " . $fileStr . " description =? , language = ? WHERE id = ?",
            [$data['description'], $data['language'], $data['id']]
        );

        if ($result) {
            return response()->json([
                'message' => __('updated'),
                'status' => true
            ]);
        } else {
            return response()->json([
                'message' => __('faild'),
                'status' => false
            ]);
        }
    }



    /* 
    
    */
    public function destroy()
    {
        // MOSTAFA_TODO delete file first
        $validator = validator(request()->dataArray(), [
            'id' => ['required'],
            'file_name' => ['required'],
        ]);
        $data = $validator->validate();
        File::delete($data['file_name']);

        database()->Run("DELETE FROM downloads Where id = ?", [$data['id']]);
        return response()->json([
            'message' => 'deleted',
            'status' => true
        ]);
    }
}
