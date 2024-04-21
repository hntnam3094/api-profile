<?php

namespace Database\Seeders;

use App\Constants\PostTypeConstant;
use App\Models\PostType;
use Illuminate\Database\Seeder;

class PostTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PostType::truncate();

        PostType::insert([
            [
                'code' => PostTypeConstant::BLOG_CODE,
                'name' => PostTypeConstant::BLOG_NAME,
                'hasCategory' => PostTypeConstant::BLOG_CATEGORY,
            ]
        ]);
    }
}
