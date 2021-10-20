<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function home()
    {
        return Inertia::render('Home');
    }

    public function reports()
    {
        return Inertia::render('Reports/Reports');
    }
}
