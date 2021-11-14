<?php

namespace App\Http\Controllers;

use App\Models\Events;
use App\Models\EventsOrganizer;
use App\Models\EventsPictures;
use App\Models\Pictures;
use App\Models\Users;
use Exception;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\DocBlock\Tags\Var_;

class GeneralController extends Controller
{

    public function index()
    {
        try {

            $eventsOrganizer = new EventsOrganizer();
            $rows = array();
            foreach ($eventsOrganizer->all() as $event) {
                $row = $this->getAllFields($event);
                array_push($rows, $row);
            }

            // $rows = json_encode($rows);
            return response()->json(["response" => $rows], 200);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }

    public function show(Request $request, EventsOrganizer $event)
    {
        try {

            $row = $this->getAllFields($event);

            return response()->json(["response" => $row], 200);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }

    private function getAllFields(EventsOrganizer $event): array
    {
        $row = array();

        $user_event = Users::where(['id' => $event['users_id']])->first();

        $row['user']['first_name'] = $user_event['first_name'];
        $row['user']['last_name'] = $user_event['last_name'];
        $row['user']['email'] = $user_event['email'];

        $data_event = Events::where(['id' => $event['events_id']])->first();

        $row['event']['id'] = $event['id'];
        $row['event']['event_name'] = $data_event['event_name'];
        $row['event']['drescription'] = $data_event['drescription'];
        $row['event']['description_donations'] = $data_event['description_donations'];
        $row['event']['latitude'] = $data_event['latitude'];
        $row['event']['longitude'] = $data_event['longitude'];
        $row['event']['date_init_event'] = $event['date_init_event'];
        $row['event']['date_end_event'] = $event['date_end_event'];
        $row['event']['phone'] = $event['phone'];

        $pictures = EventsPictures::find(['events_id' => $event['id']]);
        $rows_pictures = array();

        foreach ($pictures as $picture) {
            if ($data_pictures = Pictures::where(['id' => $picture['pictures_id']])->first()) {
                $row_pictures['id'] = $data_pictures['id'];
                $row_pictures['mimo'] = $data_pictures['mimo'];
                $row_pictures['base64'] = $data_pictures['base64'];
                $row_pictures['title'] = $data_pictures['title'];
                $row_pictures['description'] = $data_pictures['description'];
                array_push($rows_pictures, $row_pictures);
            }
        }

        $row['event']['pictures'] = $rows_pictures;

        return $row;
    }

    public function store(Request $request)
    {

        try {

            $users = UsersController::userActive();

            $events = new Events();
            $events->event_name = $request->event_name ?? '';
            $events->drescription = $request->drescription ?? '';
            $events->description_donations = $request->description_donations  ?? '';
            $events->latitude = $request->latitude  ?? 0;
            $events->longitude = $request->longitude  ?? 0;
            $events->save();

            if (!isset($events->id)) {
                throw new Exception("Não foi possível criar evento");
            }

            if (isset($request->pictures)) {
                foreach ($request->pictures as $picture) {

                    $obj_pictures = new Pictures();
                    $obj_pictures->save($picture);

                    $eventsPictures                 = new EventsPictures();
                    $eventsPictures->events_id      = $events->id;
                    $eventsPictures->users_id       = $users->id;
                    $eventsPictures->pictures_id    = $obj_pictures->id;
                    $eventsPictures->save();
                }
            }

            $eventsOrganizer = new EventsOrganizer();
            $eventsOrganizer->users_id          = $users->id;
            $eventsOrganizer->events_id         = $events->id;
            $eventsOrganizer->phone             = $request->phone  ?? '';
            $eventsOrganizer->date_init_event   = $request->date_init_event  ?? '';
            $eventsOrganizer->date_end_event    = $request->date_end_event  ?? '';
            $eventsOrganizer->save();

            return response()->json(["response" => $eventsOrganizer->id], 201);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, EventsOrganizer $event)
    {

        try {

            $users = UsersController::userActive();

            if($event->users_id != $users->id){
                throw new Exception("Você não tem permissão para alterar esse evento.");
            }

            $event->phone             = $request->phone            ?? $event->phone;
            $event->date_init_event   = $request->date_init_event  ?? $event->date_init_event;
            $event->date_end_event    = $request->date_end_event   ?? $event->date_end_event;
            $event->update();

            $data_event = Events::where(['id' => $event->events_id])->first();
            $data_event->event_name             = $request->event_name              ?? $data_event->event_name;
            $data_event->drescription           = $request->drescription            ?? $data_event->drescription;
            $data_event->description_donations  = $request->description_donations   ?? $data_event->description_donations;
            $data_event->latitude               = $request->latitude                ??  $data_event->latitude;
            $data_event->longitude              = $request->longitude               ?? $data_event->longitude;
            $data_event->update();

            if (isset($request->pictures)) {
                foreach ($request->pictures as $picture) {

                    $obj_pictures = new Pictures();
                    $obj_pictures->save($picture);

                    $eventsPictures                 = new EventsPictures();
                    $eventsPictures->events_id      = $event->events_id;
                    $eventsPictures->users_id       = $users->id;
                    $eventsPictures->pictures_id    = $obj_pictures->id;
                    $eventsPictures->save();
                }
            }
            $row = $this->getAllFields($event);
            return response()->json(["response" => $row], 200);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }
}
