<?php

namespace App\Http\Controllers;

use App\Models\Town;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TownController extends Controller
{
    // Display a listing of the resource
    public function index()
    {
        $towns = Town::all();
        return Inertia::render('Towns/Index', ['towns' => $towns]);
    }

    // Other CRUD methods (create, store, show, edit, update, destroy) go here...
}
