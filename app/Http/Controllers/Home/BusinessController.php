<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BusinessController extends Controller
{
    //
    public function Index(Request $request)
    {
        return view('frontend.default.business');
    }
}
