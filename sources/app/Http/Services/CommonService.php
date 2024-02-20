<?php
namespace App\Http\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class CommonService {
    public function saveImages ($value) {
        $path = '';
        if ($value && $value[0] && gettype($value[0]) != 'string') {
            $image = $value[0];
            $imgName = time() . time().rand(100,999) . '.' . $image->getClientOriginalExtension();
            $path = 'public/struction/' . Carbon::now()->format('Ymd') . '/' . $imgName;
            Storage::disk(config('disks.public'))->put($path, file_get_contents($image));
        }
        return $path;
    }
}
