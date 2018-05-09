<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Telegram extends Model
{
    protected $fillable = [
        'uid',
        's_type',
        'notification',
        's_fio',
        's_company',
        's_phone',
        's_email',
        's_region',
        's_city',
        's_street',
        's_building',
        's_flat',
        'r_name',
        'r_surname',
        'r_company',
        'r_phone',
        'r_email',
        'r_region',
        'r_city',
        'r_street',
        'r_building',
        'r_flat',
        'service_type',
        'text',
        'copy_date',
        'copy_number',
        'copy_direction',
        'payment_type',
        'status'
    ];
}
