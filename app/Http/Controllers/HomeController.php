<?php

namespace App\Http\Controllers;
use App\Models\Ring;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function home() {
        $rings = Ring::all();
        return view('pages.home', [
            'menuItems' => $this->menuItems
        ],compact('rings'));
    }
}
