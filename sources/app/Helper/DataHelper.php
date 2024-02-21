<?php

use Illuminate\Support\Facades\DB;

if (!function_exists('getCategory')) {
    function getCategory ($postType) {
        return [];
    }
}
