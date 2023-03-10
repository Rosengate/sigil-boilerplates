<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use Exedra\Routeller\Attributes\Path;

#[Path('/test')]
class TestApiController extends Controller
{
    public function get()
    {
        return [
            'good' => 'job'
        ];
    }
}
