<?php

namespace App\Support;

use App\Models\SiteSetting;

class SiteSettingStore
{
    public static function all(): array
    {
        return SiteSetting::query()
            ->get()
            ->mapWithKeys(function (SiteSetting $setting) {
                $value = $setting->value;

                if (is_array($value) && array_key_exists('text', $value) && count($value) === 1) {
                    return [$setting->key => $value['text']];
                }

                return [$setting->key => $value];
            })
            ->all();
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        $settings = self::all();

        return $settings[$key] ?? $default;
    }
}
