<?php

namespace App\Http\Controllers;

use App\Models\Events;
use App\Models\EventsOrganizer;
use App\Models\EventsPictures;
use App\Models\Pictures;
use App\Models\Users;
use Exception;
use Illuminate\Http\Request;

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

    public function eventsProfileActive(){

        try {

            $userActive = UsersController::userActive();
            $eventsOrganizer = EventsOrganizer::where(['users_id' => $userActive['id']]);
            $rows = array();
            foreach ($eventsOrganizer->get() as $event) {
                $row = $this->getAllFields($event);
                array_push($rows, $row);
            }
            return response()->json(["response" => $rows], 200);
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

        $row['event']['pictures'] = EventsPicturesController::getPicturesByEvents($event['id']);

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

            if ($files = $request->file()) {
                foreach ($files as $name => $file) {

                    $fileMime = $file->getMimeType();
                    // Upload Image
                    $path = $request->file($name)->store('imgs', 's3');

                    $pictures = new Pictures();
                    $pictures->mime      = $fileMime;
                    $pictures->pathFile  = EventsPicturesController::fileName($path);

                    if ($pictures->save()) {
                        $eventsPictures                 = new EventsPictures();
                        $eventsPictures->events_id      = $events->id;
                        $eventsPictures->users_id       = $users->id;
                        $eventsPictures->pictures_id    = $pictures->id;
                        $eventsPictures->save();
                    }
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

            if ($event->users_id != $users->id) {
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

            if ($files = $request->file()) {
                foreach ($files as $name => $file) {

                    $fileMime = $file->getMimeType();
                    // Upload Image
                    $path = $request->file($name)->store('imgs', 's3');

                    $pictures = new Pictures();
                    $pictures->mime      = $fileMime;
                    $pictures->pathFile  = EventsPicturesController::fileName($path);

                    if ($pictures->save()) {
                        $eventsPictures                 = new EventsPictures();
                        $eventsPictures->events_id      = $event->id;
                        $eventsPictures->users_id       = $users->id;
                        $eventsPictures->pictures_id    = $pictures->id;
                        $eventsPictures->save();
                    }
                }
            }

            $row = $this->getAllFields($event);
            return response()->json(["response" => $row], 200);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }
}
