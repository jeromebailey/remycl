<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePersonaldetailRequest;
use App\Http\Requests\UpdatePersonaldetailRequest;
use App\Models\Personaldetail;

class PersonaldetailController extends Controller
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
     * @param  \App\Http\Requests\StorePersonaldetailRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePersonaldetailRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Personaldetail  $personaldetail
     * @return \Illuminate\Http\Response
     */
    public function show(Personaldetail $personaldetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Personaldetail  $personaldetail
     * @return \Illuminate\Http\Response
     */
    public function edit(Personaldetail $personaldetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePersonaldetailRequest  $request
     * @param  \App\Models\Personaldetail  $personaldetail
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePersonaldetailRequest $request, Personaldetail $personaldetail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Personaldetail  $personaldetail
     * @return \Illuminate\Http\Response
     */
    public function destroy(Personaldetail $personaldetail)
    {
        //
    }
}
