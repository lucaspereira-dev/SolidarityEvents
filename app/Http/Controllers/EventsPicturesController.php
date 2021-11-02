<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, EventsPictures $eventsPictures)
    {
        
        try {

            $validator = Validator::make($request->all(), $eventsPictures->rules(), $eventsPictures->messages());

            if ($validator->stopOnFirstFailure()->fails()) {
                return response()->json(["error" => $validator->messages()], 403);
            }

            $eventsPictures->events_id = $request->events_id ?? '';
            $eventsPictures->pictures_id = $request->pictures_id ?? '';
            

            if (!$eventsPictures->save()) {
                return response()->json(["response" => false], 200);
            }

            return response()->json(["response" => $eventsPictures], 201);
        } catch (\Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EventsPictures  $eventsPictures
     * @return \Illuminate\Http\Response
     */
    public function show(EventsPictures $eventsPictures)
    {
        return response()->json(["response" =>  $eventsPictures], 200);  
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
        try {

            $data_request = $request->all();
            if (!$eventsPictures->update($data_request)) {
                return response()->json(["response" => false], 200);
            }

            return response()->json(["response" => $eventsPictures], 200);
        } catch (\Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EventsPictures  $eventsPictures
     * @return \Illuminate\Http\Response
     */
    public function destroy(EventsPictures $eventsPictures)
    {
        $id = $eventsPictures->id;
        return response()->json(["response" => (bool)$eventsPictures->destroy($id)], 200);
    }
}
