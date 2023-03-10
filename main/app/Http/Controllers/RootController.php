<?php

namespace App\Http\Controllers;

class RootController extends Controller
{
    public function groupWeb()
    {
        return WebController::class;
    }

    public function groupApis()
    {
        return ApisController::class;
    }

    public function groupSamples()
    {
        return SamplesController::class;
    }
}
