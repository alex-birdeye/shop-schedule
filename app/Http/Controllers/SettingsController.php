<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveSettingsRequest;
use App\Services\ShopSettingsService;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    private $shopSettingsService;

    public function __construct(ShopSettingsService $shopSettingsService)
    {
        $this->shopSettingsService = $shopSettingsService;
    }


    public function index()
    {
        return $this->shopSettingsService->getAllSettings();
    }

    public function store(SaveSettingsRequest $request)
    {
        $this->shopSettingsService->saveAllSettings($request->validated());

        return 'success';
    }
}
