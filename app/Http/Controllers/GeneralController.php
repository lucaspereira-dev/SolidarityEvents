<?php

namespace App\Http\Controllers;

use App\Models\Events;
use App\Models\EventsOrganizer;
use App\Models\EventsPictures;
use App\Models\Pictures;
use App\Models\Users;
use Illuminate\Http\Request;

class GeneralController extends Controller
{

    public function index(){

    }

    public function store(Request $request){

        $users = new Users();
        $users->fist_name       = $request->fist_name ?? '';
        $users->last_name       = $request->last_name ?? '';
        $users->email           = $request->email  ?? '';
        $users->password        = sha1($request->password  ?? '1234');


        $events = new Events();
        $events->event_name = $request->event_name ?? '';
        $events->drescription = $request->drescription ?? '';
        $events->description_donations = $request->description_donations  ?? '';
        $events->latitude = $request->latitude  ?? '';
        $events->longitude = $request->longitude  ?? '';

        $eventsOrganizer = new EventsOrganizer();
        $eventsOrganizer->users_id          = $request->users_id ?? '';
        $eventsOrganizer->events_id         = $request->events_id  ?? '';
        $eventsOrganizer->phone             = $request->phone  ?? '';
        $eventsOrganizer->date_init_event   = $request->date_init_event  ?? '';
        $eventsOrganizer->date_end_event    = $request->date_end_event  ?? '';

        $pictures = new Pictures();
        $pictures->hash         = $request->hash ?? '';
        $pictures->mimo         = $request->mimo ?? '';
        $pictures->dir          = $request->dir  ?? '';
        $pictures->title        = $request->title  ?? '';
        $pictures->description  = $request->description  ?? '';

        $eventsPictures = new EventsPictures();
        $eventsPictures->events_id = $request->events_id ?? '';
        $eventsPictures->pictures_id = $request->pictures_id ?? '';

        

        
    }
}
