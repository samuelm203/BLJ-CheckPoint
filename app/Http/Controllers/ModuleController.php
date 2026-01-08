<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ModuleController extends Controller
{
    public function index() {
        $modules = \App\Models\Module::with('tasks')->get();
        return view('modules.index', compact('modules'));
    }
}


