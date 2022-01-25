<?php
/**
 * Created by PhpStorm.
 * User: youser
 * Date: 24.01.22
 * Time: 21:38
 */

namespace App\Services;


use App\Models\ShopSettings;

class ShopSettingsService
{

    public function getAllSettings()
    {
        $allSettings = ShopSettings::all();

        return $allSettings->keyBy('setting_name')
                           ->map(function ($setting)
                           {
                               return $setting->data;
                           });
    }

    public function saveAllSettings($settings)
    {
        foreach ($settings as $settingName => $data)
        {
            ShopSettings::where('setting_name', $settingName)->update(['data' => $data]);
        }
    }
}