<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SavedReceiver extends Model
{
    protected $table = "receivers";
    protected $fillable = [
        "uid", "template_name", "name", "surname", "company", "phone", "email", "region", "city", "street", "building", "flat",
    ];
}