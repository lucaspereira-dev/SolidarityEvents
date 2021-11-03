<?php

namespace App\Http\Controllers;

use App\Models\Events;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EventsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Events $events)
    {
        return response()->json(["response" =>events::all()], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Events $events)
    {
        try {

            $validator = Validator::make($request->all(), $events->rules(), $events->messages());

            if ($validator->stopOnFirstFailure()->fails()) {
                return response()->json(["error" => $validator->messages()], 403);
            }

            $events->event_name = $request->event_name ?? '';
            $events->drescription = $request->drescription ?? '';
            $events->description_donations = $request->description_donations  ?? '';
            $events->latitude = $request->latitude  ?? '';
            $events->longitude = $request->longitude  ?? '';

            if (!$events->save()) {
                return response()->json(["response" => false], 200);
            }

            return response()->json(["response" => $events], 201);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Events  $events
     * @return \Illuminate\Http\Response
     */
    public function show(Events $events)
    {
        return response()->json(["response" =>  $events], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Events  $events
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Events $events)
    {
        try {

            $data_request = $request->all();
            if (!$events->update($data_request)) {
                return response()->json(["response" => false], 200);
            }

            return response()->json(["response" => $events], 200);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Events  $events
     * @return \Illuminate\Http\Response
     */
    public function destroy(Events $events)
    {
        $id = $events->id;
        return response()->json(["response" => (bool)$events->destroy($id)], 200);
    }
}
