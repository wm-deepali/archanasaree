<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class HomePageController extends Controller
{
    public function index()
    {
        return view('admin.home.index');
    }
}