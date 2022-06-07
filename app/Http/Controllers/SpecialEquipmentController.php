<?php

namespace App\Http\Controllers;

use App\Models\SpecialEquipment;
use App\Http\Requests\StoreSpecialEquipmentRequest;
use App\Http\Requests\UpdateSpecialEquipmentRequest;

class SpecialEquipmentController extends Controller
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
     * @param  \App\Http\Requests\StoreSpecialEquipmentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSpecialEquipmentRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SpecialEquipment  $specialEquipment
     * @return \Illuminate\Http\Response
     */
    public function show(SpecialEquipment $specialEquipment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SpecialEquipment  $specialEquipment
     * @return \Illuminate\Http\Response
     */
    public function edit(SpecialEquipment $specialEquipment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSpecialEquipmentRequest  $request
     * @param  \App\Models\SpecialEquipment  $specialEquipment
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSpecialEquipmentRequest $request, SpecialEquipment $specialEquipment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SpecialEquipment  $specialEquipment
     * @return \Illuminate\Http\Response
     */
    public function destroy(SpecialEquipment $specialEquipment)
    {
        //
    }
}
