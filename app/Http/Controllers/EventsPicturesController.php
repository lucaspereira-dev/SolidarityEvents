<?php

namespace App\Http\Controllers;

use App\Models\EventsPictures;
use Illuminate\Http\Request;

class EventsPicturesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, EventsPictures $eventsPictures)
    {
        return response()->json($eventsPictures::all(), 200);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EventsPictures  $eventsPictures
     * @return \Illuminate\Http\Response
     */
    public function show(EventsPictures $eventsPictures)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EventsPictures  $eventsPictures
     * @return \Illuminate\Http\Response
     */
    public function edit(EventsPictures $eventsPictures)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EventsPictures  $eventsPictures
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EventsPictures $eventsPictures)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EventsPictures  $eventsPictures
     * @return \Illuminate\Http\Response
     */
    public function destroy(EventsPictures $eventsPictures)
    {
        //
    }
}
