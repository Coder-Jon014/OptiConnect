<?php

namespace App\Http\Controllers;

use App\Models\OLT;
use App\Http\Requests\StoreOLTRequest;
use App\Http\Requests\UpdateOLTRequest;
use App\Http\Resources\OLTResource;

class OLTController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $olts = OLT::with(['parish', 'town', 'resource'])->get();

        return inertia('OLTS/Index', [
            "olts" => OLTResource::collection($olts),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOLTRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(OLT $oLT)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OLT $oLT)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOLTRequest $request, OLT $oLT)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OLT $oLT)
    {
        //
    }
}
