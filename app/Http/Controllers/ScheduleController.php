<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function isOpened(Request $request)
    {
        return response()->json(['is_opened' => false]);
    }
}
