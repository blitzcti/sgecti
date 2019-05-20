<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CoordinatorMessageController extends Controller
{
    public function index()
    {
        return view('coordinator.message.index');
    }
}
