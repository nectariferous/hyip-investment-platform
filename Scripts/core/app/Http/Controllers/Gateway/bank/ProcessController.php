<?php 
namespace App\Http\Controllers\Gateway\bank;

use App\Http\Controllers\Controller;

class ProcessController extends Controller
{
    public static function process($request, $gateway, $amount , $deposit)
    {
        $validation = [];
        if ($gateway->user_proof_param != null) {
            foreach ($gateway->user_proof_param as $params) {
                if ($params['type'] == 'text' || $params['type'] == 'textarea') {

                    $key = strtolower(str_replace(' ', '_', $params['field_name']));

                    $validationRules = $params['validation'] == 'required' ? 'required' : 'sometimes';

                    $validation[$key] = $validationRules;
                } else {

                    $key = strtolower(str_replace(' ', '_', $params['field_name']));

                    $validationRules = ($params['validation'] == 'required' ? 'required' : 'sometimes') . "|image|mimes:jpg,png,jpeg|max:2048";

                    $validation[$key] = $validationRules;
                }
            }
        }

        $data = $request->validate($validation);

        foreach ($data as $key => $upload) {

            if ($request->hasFile($key)) {

                $filename = uploadImage($upload, filePath('manual_payment'));

                $data[$key] = ['file' => $filename, 'type' => 'file'];
            }
        }

        $deposit->payment_proof = $data;

        $deposit->payment_type = 0;

        $deposit->payment_status = 2;

        $deposit->save();
    }
}