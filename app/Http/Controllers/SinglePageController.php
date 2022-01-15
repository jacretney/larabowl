<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class SinglePageController extends Controller
{
    public function __invoke(): Factory|View|Application
    {
        return view('index');
    }
}
