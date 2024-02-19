<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostDetail extends Model
{
    use HasFactory;

    protected $table = 'post_detail';
    protected $fillable = ['postTypeId', 'status', 'sequence'];
}
