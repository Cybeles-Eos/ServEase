<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function setting()
    {
        return view('admin.cussetting');
    }
}
