<?php  

namespace App\Http\Controllers;

/**
* 
*/
class ValidationRules
{

    const UserRules = [
            'user_type' => 'required|string|max:3',
            'fio' => 'required|string|max:150',
            'email' => 'sometimes|required|string|email|max:150|unique:users',
            'password' => 'sometimes|required|string|min:3|confirmed',
            'region' => 'string|max:100|nullable',
            'city' => 'string|max:100|nullable',
            'street' => 'string|max:100|nullable',
            'building' => 'string|max:20|nullable',
            'flat' => 'numeric|nullable',
            'company' => 'string|max:150|nullable',
            'phone' => 'numeric|nullable',
        ];
}

?>