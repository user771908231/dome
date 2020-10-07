<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DemandController extends Controller
{
    //
    public function Index(Request $request)
    {
       dd($request->input("mes"));
    }
}
