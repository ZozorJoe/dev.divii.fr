<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

class PageController extends Controller
{
    public function about(){
        return view('page.about');
    }

    public function terms(){
        return view('page.terms');
    }

    public function policy(){
        return view('page.policy');
    }

    public function cookie(){
        return view('page.cookie');
    }

    public function accessibility(){
        return view('page.accessibility');
    }
}
