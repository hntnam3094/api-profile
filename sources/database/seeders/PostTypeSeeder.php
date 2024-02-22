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
                'code' => PostTypeConstant::PRODUCT_CODE,
                'name' => PostTypeConstant::PRODUCT_NAME,
                'hasCategory' => PostTypeConstant::PRODUCT_CATEGORY,
            ],
            [
                'code' => PostTypeConstant::BOOKING_CODE,
                'name' => PostTypeConstant::BOOKING_NAME,
                'hasCategory' => PostTypeConstant::BOOKING_CATEGORY,
            ]
        ]);
    }
}
