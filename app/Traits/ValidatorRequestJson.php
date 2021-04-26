<?php

namespace app\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

trait ValidatorRequestJson {

    protected function validateRequestJsonFunction(Request $request, array $rules, $messages = [], $customAtributes = []) {
        
        $validated = false;
        $errors = [];

        $validator = Validator::make($request->all(), $rules, $messages, $customAtributes);

        if($validator->fails()) {
            $errors = $validator->errors->toArray();
        }
         else{
             $validated = true;
            } 
        
        return (object) ["validated" => $validated, "errors" => $errors];
    }
    

}