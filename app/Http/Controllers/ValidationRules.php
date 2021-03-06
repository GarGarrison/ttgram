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
            'country' => 'string|max:100|nullable',
            'region' => 'string|max:100|nullable',
            'city' => 'string|max:100|nullable',
            'street' => 'string|max:100|nullable',
            'building' => 'string|max:20|nullable',
            'flat' => 'numeric|nullable',
            'company' => 'string|max:150|nullable',
            'inn' => 'numeric|digits:12|nullable',
            'kpp' => 'numeric|digits:12|nullable',
            'phone' => 'digits:10|nullable',
        ];
    // +7 (123) 456-78-90 => 1234567890
    public static function phoneConvert($phone) {
        $phone = str_replace("+7", "", $phone);
        $phone = str_replace(" ", "", $phone);
        $phone = str_replace("(", "", $phone);
        $phone = str_replace(")", "", $phone);
        $phone = str_replace("-", "", $phone);
        return $phone;
    }

    public static function dataPhoneConvert($data, $names) {
        foreach ($names as $name) {
            if (!isset($data[$name])) continue;
            $tmp = self::phoneConvert($data[$name]);
            $data[$name] = $tmp;
        }
        return $data;
    }
}

?>