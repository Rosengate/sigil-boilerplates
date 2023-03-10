<?php

namespace App\Http\Controllers;

class RootController extends Controller
{
    public function groupWeb()
    {
        return WebController::class;
    }
}
