<?php

namespace App\Http\Controllers;

use App\Models\OutageHistory;
use App\Http\Requests\StoreOutageHistoryRequest;
use App\Http\Requests\UpdateOutageHistoryRequest;

class OutageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(StoreOutageHistoryRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(OutageHistory $outageHistory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OutageHistory $outageHistory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOutageHistoryRequest $request, OutageHistory $outageHistory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OutageHistory $outageHistory)
    {
        //
    }
}
