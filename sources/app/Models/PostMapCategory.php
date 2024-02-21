<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostMapCategory extends Model
{
    use HasFactory;

    protected $table = 'post_map_category';
    protected $fillable = ['postId', 'categoryId'];
}
