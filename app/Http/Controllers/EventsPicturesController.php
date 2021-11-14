<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Models\EventsPictures;
use App\Models\Pictures;
use App\Models\EventsOrganizer;
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
        return response()->json(["response" => eventsPictures::all()], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, EventsOrganizer $event)
    {
        
        // try {

        //     return response()->json(["response" => $eventsPictures], 201);
        // } catch (\Exception $e) {
        //     return response()->json(["error" => $e->getMessage()], 500);
        // }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EventsPictures  $eventsPictures
     * @return \Illuminate\Http\Response
     */
    public function show(Pictures $id)
    {
        return response()->json(["response" =>  $id], 200);  
    }

    public function validUser($picture_id){
        if($obj_events_pictures =  EventsPictures::where(['pictures_id' => $picture_id])->first()){
            if($user = UsersController::userActive()){
                return $obj_events_pictures->users_id == $user->id;
            }
        }

        return false;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EventsPictures  $eventsPictures
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pictures $id)
    {
        try {

            if(isset($id->id) && !$this->validUser($id->id)){
                throw new \Exception("Usuário não tem permissão");
            }

            $id->mimo          = $request->mimo;;
            $id->base64        = $request->base64;
            $id->title         = $request->title;
            $id->description   = $request->description;

            if (!$id->update()) {
                return response()->json(["response" => false], 401);
            }

            return response()->json(["response" => $id], 200);
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
    public function destroy(Pictures $id)
    {
        $id = $id->id;

        if(!$this->validUser($id)){
            throw new \Exception("Usuário não tem permissão");
        }

        if($obj_events_pictures =  EventsPictures::where(['pictures_id' => $id])->first()){
            if(!(bool)$obj_events_pictures->destroy($obj_events_pictures->id)){
                return false;
            }
        }

        return response()->json(["response" => (bool)$id->destroy($id)], 200);
    }
}
