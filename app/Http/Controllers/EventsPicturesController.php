<?php

namespace App\Http\Controllers;

use Storage;
use App\Models\EventsPictures;
use App\Models\Pictures;
use App\Models\EventsOrganizer;
use Illuminate\Http\Request;

class EventsPicturesController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, EventsOrganizer $event)
    {
        try {

            $users = UsersController::userActive();

            if ($event->users_id != $users->id) {
                throw new \Exception("Você não tem permissão para alterar esse evento.");
            }

            if ($files = $request->file()) {
                foreach ($files as $name => $file) {
                    
                    $fileMime = $file->getMimeType();
                    $fileOriginalName = $file->getClientOriginalName();
                    $filePathInfo = pathinfo($fileOriginalName);
                    $hashFile = md5($name);
                    $fileNameToStore = $hashFile . '_' . time() . '.' . $filePathInfo['extension'];

                    // Upload Image
                    $path = Storage::disk('s3')->put($fileNameToStore, file_get_contents($file));

                    $pictures = new Pictures();
                    $pictures->mime      = $fileMime;
                    $pictures->pathFile  = $path;

                    if ($pictures->save()) {
                        $eventsPictures                 = new EventsPictures();
                        $eventsPictures->events_id      = $event->id;
                        $eventsPictures->users_id       = $users->id;
                        $eventsPictures->pictures_id    = $pictures->id;
                        $eventsPictures->save();
                    }
                }
            }

            return response()->json(["response" => true], 201);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }

    public static function getPicturesByEvents($events_id): array{
        
        $pictures = EventsPictures::where(['events_id' => $events_id]);

        $rows_pictures = array();
        $url_base = url('/');

        foreach ($pictures->get() as $picture) {
            if ($data_pictures = Pictures::where(['id' => $picture['pictures_id']])->first()) {
                
                $row_pictures['id'] = $data_pictures['id'];
                $row_pictures['mime'] = $data_pictures['mime'];
                $row_pictures['url'] = $url_base . Storage::url($data_pictures['pathFile']);;
                array_push($rows_pictures, $row_pictures);
            }
        }

        return $row_pictures;
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

        if (!$this->validUser($id)) {
            throw new \Exception("Usuário não tem permissão");
        }

        if ($obj_events_pictures =  EventsPictures::where(['pictures_id' => $id])->first()) {
            if (!(bool)$obj_events_pictures->destroy($obj_events_pictures->id)) {
                return false;
            }
        }

        return response()->json(["response" => (bool)$id->destroy($id)], 200);
    }
}
