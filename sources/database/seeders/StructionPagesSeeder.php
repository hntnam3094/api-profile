<?php

namespace Database\Seeders;

use App\Constants\FormConstant;
use App\Models\StructionPages;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

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
                'title' => FormConstant::HOME_SLIDER_NAME
            ],
            [
                'pageCode' => FormConstant::HOME,
                'code' => FormConstant::HOME_STORY,
                'singleRow' => 1,
                'title' => FormConstant::HOME_STORY_NAME
            ]
        ]);
    }
}
