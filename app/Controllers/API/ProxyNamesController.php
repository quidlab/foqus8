<?php

namespace App\Controllers\API;

use App\Controllers\Controller;
use App\Exceptions\ValidationException;

class ProxyNamesController extends Controller
{

    public function index()
    {
        $data = database()->Select("SELECT * From [Proxy_names]");
        return response()->json($data);
    }



    public function store()
    {
        $validator = validator(request()->dataArray(), [
            'Proxy_Name' => ['required']
        ]);

        try {
            $data = $validator->validate();
        } catch (ValidationException $th) {
            return response()->json([
                'message' => $th->error(),
                'status' => false
            ]);
        }
        $result = database()->Run("INSERT INTO Proxy_names (Proxy_Name) VALUES (?)", [$data['Proxy_Name']]);
        return response()->json([
            'message' => __($result ? 'created' : 'somthing-went-wrong'),
            'status' => $result
        ]);
    }



    public function destroy()
    {
        $validator = validator(request()->dataArray(), [
            'Proxy_Name' => ['required']
        ]);

        try {
            $data = $validator->validate();
        } catch (ValidationException $th) {
            return response()->json([
                'message' => $th->error(),
                'status' => false
            ]);
        }


        $result = database()->Run("DELETE FROM Proxy_names WHERE Proxy_Name = ?", [$data['Proxy_Name']]);
        return response()->json([
            'message' => __($result ? 'deleted' : 'somthing-went-wrong'),
            'status' => $result
        ]);
    }
}
