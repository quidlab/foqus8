<?php

namespace App\Controllers\API;

use App\Controllers\Controller;
use App\Exceptions\ValidationException;

class CouponsController extends Controller
{

    public function index()
    {
        $data = database()->Select("SELECT * From [coupons]");
        return response()->json($data);
    }


    /* 
    
    */
    public function store()
    {
        $validator = validator(request()->dataArray(), [
            'coupon-id' => ['required'],
            'name' => ['required'],
            'language' => ['required'],
            'print-coupon' => ['required'],
            'coupon-type' => ['required'],
        ]);

        try {
            $data = $validator->validate();
        } catch (ValidationException $th) {
            return response()->json([
                'message' => $th->error(),
                'status' => false
            ]);
        }
        $result = database()->Run(
            "INSERT INTO coupons ([coupon-id],[name],[language],[print-coupon],[coupon-type]) VALUES (?,?,?,?,?)",
            [
                $data['coupon-id'],
                $data['name'],
                $data['language'],
                $data['print-coupon'],
                $data['coupon-type'],
            ]
        );
        return response()->json([
            'message' => __($result ? 'created' : 'somthing-went-wrong'),
            'status' => $result
        ]);
    }



    public function update()
    {
        $validator = validator(request()->dataArray(), [
            'name' => ['required'],
            'language' => ['required'],
            'print-coupon' => ['required'],
            'coupon-type' => ['required'],
            'ID' => ['required'],
        ]);

        try {
            $data = $validator->validate();
        } catch (ValidationException $th) {
            return response()->json([
                'message' => $th->error(),
                'status' => false
            ]);
        }

        $result = database()->Run("UPDATE coupons SET [name] = ?, [language] = ? ,[coupon-type] = ?,[print-coupon] = ? WHERE ID = ?", [
            $data['name'],
            $data['language'],
            $data['coupon-type'],
            $data['print-coupon'],
            $data['ID'],
        ]);
        return response()->json([
            'message' => __($result ? 'updated' : 'somthing-went-wrong'),
            'status' => $result
        ]);
    }



    /* 
    
    */
    public function destroy()
    {
        $validator = validator(request()->dataArray(), [
            'ID' => ['required'],
        ]);

        try {
            $data = $validator->validate();
        } catch (ValidationException $th) {
            return response()->json([
                'message' => $th->error(),
                'status' => false
            ]);
        }


        $result = database()->Run("DELETE FROM coupons WHERE ID = ?", [$data['ID']]);
        return response()->json([
            'message' => __($result ? 'deleted' : 'somthing-went-wrong'),
            'status' => $result
        ]);
    }
}
