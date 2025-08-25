<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $guarded = [];

    /**
     * Get setting value by key
     */
    public static function getValue(string $key, $default = null)
    {
        $cacheKey = "setting_{$key}";

        return Cache::remember($cacheKey, 3600, function () use ($key, $default) {
            $setting = static::where('key', $key)->first();
            return $setting ? $setting->value : $default;
        });
    }

    /**
     * Set setting value by key
     */
    public static function setValue(string $key, $value, string $type = 'string', string $group = 'general', string $description = null)
    {
        $setting = static::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'type' => $type,
                'group' => $group,
                'description' => $description,
            ]
        );

        // Clear cache
        Cache::forget("setting_{$key}");

        return $setting;
    }

    /**
     * Get all settings by group
     */
    public static function getByGroup(string $group)
    {
        return static::where('group', $group)->get();
    }

    /**
     * Get WO prefix
     */
    public static function getWOPrefix(): string
    {
        return static::getValue('wo_prefix', '86');
    }

    /**
     * Set WO prefix
     */
    public static function setWOPrefix(string $prefix): void
    {
        static::setValue('wo_prefix', $prefix, 'string', 'wo', 'Prefix nomor awal untuk Work Order');
    }
}
