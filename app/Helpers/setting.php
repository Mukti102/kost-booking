<?php

use App\Models\Setting;

if (!function_exists('setting')) {

    function setting($key, $default = null)
    {
        $item = Setting::where('key',$key)->first();

        return $item ? $item->value : $default;
    }
}
