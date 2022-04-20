<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;

class IndexController extends WebController
{
    public function welcome(Request $request)
    {
        $user = $request->user();
        if($user && $user->is_tester){
            return redirect()
                ->route('home');
        }

        return view('app');
    }

    public function index()
    {
        return view('app');
    }
}
