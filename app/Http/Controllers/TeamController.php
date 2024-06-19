<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TeamController extends Controller
{
    // Display a listing of the resource
    public function index()
    {
        $teams = Team::all();
        return Inertia::render('Teams/Index', ['teams' => $teams]);
    }

    // Other CRUD methods (create, store, show, edit, update, destroy) go here...
}
