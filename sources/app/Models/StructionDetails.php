<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StructionDetails extends Model
{
    use HasFactory;

    protected $fillable = ['structionPageId', 'status', 'sequence'];

    protected static function boot () {
        parent::boot();

        static::deleting(function ($structionDetail) {
            $structionDetail->structionMetas()->delete();
        });
    }

    public function structionMetas () {
        return $this->hasMany(StructionMetas::class, 'structionDetailId', 'id');
    }
}
