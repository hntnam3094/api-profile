<?php

namespace Database\Seeders;

use App\Constants\FormConstant;
use App\Models\StructionPages;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StructionPagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        StructionPages::truncate();

        StructionPages::insert([
            [
                'pageCode' => FormConstant::HOME,
                'code' => FormConstant::HOME_SLIDER,
                'singleRow' => 0,
                'title' => 'Home Slider - Top',
            ],
            [
                'pageCode' => FormConstant::HOME,
                'code' => FormConstant::HOME_STORY,
                'singleRow' => 1,
                'title' => 'Home Story',
            ]
        ]);
    }
}
