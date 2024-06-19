<?php

namespace App\Http\Controllers;

use App\Models\OLT;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OLTController extends Controller
{
    // Display a listing of the resource
    public function index()
    {
        $olts = OLT::all();
        return Inertia::render('OLTs/Index', ['olts' => $olts]);
    }

    // Other CRUD methods (create, store, show, edit, update, destroy) go here...
}
