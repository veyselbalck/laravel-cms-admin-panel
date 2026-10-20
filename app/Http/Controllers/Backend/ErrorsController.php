<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ErrorsController extends Controller
{
    public function index() {
        return view('panel.error');
    }
}
