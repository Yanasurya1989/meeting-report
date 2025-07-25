<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotulenController extends Controller
{
    public function create()
    {
        return view('meeting.create');
    }
}
