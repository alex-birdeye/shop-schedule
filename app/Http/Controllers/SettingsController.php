<?php

namespace App\Http\Controllers;

use App\Models\ShopSettings;
use App\Services\ShopSettingsService;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    private $shopSettingsService;

    public function __construct(ShopSettingsService $shopSettingsService)
    {
        $this->shopSettingsService = $shopSettingsService;
    }


    public function index(Request $request)
    {
        return $this->shopSettingsService->getAllSettings();
    }
}
