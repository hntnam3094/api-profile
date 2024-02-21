<?php

namespace Database\Seeders;

use App\Constants\Forms\Posttype\BookingConstant;
use App\Constants\Forms\Posttype\ProductConstant;
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
                'code' => ProductConstant::CODE,
                'name' => ProductConstant::NAME,
                'hasCategory' => ProductConstant::HAS_CATEGORY,
            ],
            [
                'code' => BookingConstant::CODE,
                'name' => BookingConstant::NAME,
                'hasCategory' => ProductConstant::HAS_CATEGORY,
            ]
        ]);
    }
}
