<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Samples\StripeSamplesController;
use Exedra\Routeller\Attributes\Path;

#[Path('/samples')]
class SamplesController extends Controller
{
    public function groupStripe()
    {
        return StripeSamplesController::class;
    }
}
