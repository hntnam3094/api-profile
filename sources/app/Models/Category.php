<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = 'category';
    protected $fillable = ['postType', 'parentId', 'status', 'sequence'];

    protected static function boot () {
        parent::boot();

        static::deleting(function ($category) {
            $category->postMapCategory()->delete();
            $category->categoryMeta()->delete();
        });
    }

    public function postMapCategory () {
        return $this->hasOne(PostMapCategory::class, 'categoryId', 'id');
    }

    public function categoryMeta () {
        return $this->hasMany(CategoryMeta::class, 'categoryId', 'id');
    }
}
