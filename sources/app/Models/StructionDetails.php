<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StructionDetails extends Model
{
    use HasFactory;

    protected $fillable = ['structionPageId', 'status', 'sequence'];
}
