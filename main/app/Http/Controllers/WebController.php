<?php

namespace App\Http\Controllers;

use Exedra\Routeller\Attributes\Path;

#[Path('/')]
class WebController extends Controller
{
    #[Path('/')]
    public function get()
    {
        return view('welcome-sigil');
    }
}
