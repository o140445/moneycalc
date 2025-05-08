<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Calculator extends Model
{
    protected $table = 'calculator';
    protected $fillable = ['name', 'description', 'url', 'icon'];
}
