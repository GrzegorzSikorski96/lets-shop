<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\API\APIController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends APIController
{
    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'min:3|required',
            'email' => 'email|required|unique:users',
            'password' => 'min:4|required',
            'password_confirmation' => 'same:password|required',
        ]);

        if ($validator->fails()) {
            return $this->response
                ->setMessage(__('messages.validation'))
                ->setData($validator->errors())
                ->setFailureStatus(400)
                ->getResponse();
        }

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);

        return $this->response
            ->setMessage("Zarejestrowano pomyślnie.")
            ->setSuccessStatus()
            ->getResponse();
    }
}
