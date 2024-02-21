<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostDetail extends Model
{
    use HasFactory;

    protected $table = 'post_detail';
    protected $fillable = ['postTypeId', 'status', 'sequence'];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($postDetail) {
            $postDetail->postMapCategory()->delete();
            $postDetail->postMeta()->delete();
        });
    }

    public function postMapCategory () {
        return $this->hasOne(PostMapCategory::class, 'postId', 'id');
    }

    public function postMeta () {
        return $this->hasMany(PostMeta::class, 'postDetailId', 'id');
    }
}
