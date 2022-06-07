<?php

namespace App\Http\Controllers;

use App\Models\Ranting;
use App\Http\Requests\StoreRantingRequest;
use App\Http\Requests\UpdateRantingRequest;

class RantingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreRantingRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRantingRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ranting  $ranting
     * @return \Illuminate\Http\Response
     */
    public function show(Ranting $ranting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ranting  $ranting
     * @return \Illuminate\Http\Response
     */
    public function edit(Ranting $ranting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRantingRequest  $request
     * @param  \App\Models\Ranting  $ranting
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRantingRequest $request, Ranting $ranting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ranting  $ranting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ranting $ranting)
    {
        //
    }
}
