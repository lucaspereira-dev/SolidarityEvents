<?php

namespace App\Http\Controllers;

use App\Models\EventsOrganizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;
use phpDocumentor\Reflection\DocBlock\Tags\Var_;

class EventsOrganizerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, EventsOrganizer $eventsOrganizer)
    {

        return response()->json($eventsOrganizer::all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, EventsOrganizer $eventsOrganizer)
    {
        try {

            $validator = Validator::make($request->all(), $eventsOrganizer->rules(), $eventsOrganizer->messages());

            if ($validator->stopOnFirstFailure()->fails()) {
                return response()->json(["error" => $validator->messages()], 403);
            }

            $eventsOrganizer->status            = $request->status ?? '';
            $eventsOrganizer->users_id          = $request->users_id ?? '';
            $eventsOrganizer->events_id         = $request->events_id  ?? '';
            $eventsOrganizer->phone             = $request->phone  ?? '';
            $eventsOrganizer->date_init_event   = $request->date_init_event  ?? '';
            $eventsOrganizer->date_end_event    = $request->date_end_event  ?? '';

            if (!$eventsOrganizer->save()) {
                return response()->json(["response" => false], 200);
            }

            return response()->json(["response" => $eventsOrganizer], 201);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EventsOrganizer  $eventsOrganizer
     * @return \Illuminate\Http\Response
     */
    public function show(EventsOrganizer $eventsOrganizer)
    {
        return response()->json(["response" =>  $eventsOrganizer], 200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EventsOrganizer  $eventsOrganizer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EventsOrganizer $eventsOrganizer)
    {
        try {

            $data_request = $request->all();
            if (!$eventsOrganizer->update($data_request)) {
                return response()->json(["response" => false], 200);
            }

            return response()->json(["response" => $eventsOrganizer], 200);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EventsOrganizer  $eventsOrganizer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, EventsOrganizer $eventsOrganizer)
    {
        $id = $eventsOrganizer->id;
        return response()->json(["response" => (bool)$eventsOrganizer->destroy($id)], 200);
    }
}
