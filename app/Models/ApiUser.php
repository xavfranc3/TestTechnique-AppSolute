<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiUser extends Model implements Authenticatable
{
    use HasFactory;
    use \Illuminate\Auth\Authenticatable;


    protected $fillable = [
        'user_name',
        'password'
    ];
}
