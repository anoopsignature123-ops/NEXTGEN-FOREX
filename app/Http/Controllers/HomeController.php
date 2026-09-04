<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $packages = Package::where('status', 'active')->get();

        return view('landing', compact('packages'));
    }
}
