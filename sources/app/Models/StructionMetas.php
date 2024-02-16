<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StructionMetas extends Model
{
    use HasFactory;

    protected $fillable = ['structionDetailId', 'key', 'value'];
}
