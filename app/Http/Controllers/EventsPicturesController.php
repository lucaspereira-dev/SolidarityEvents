<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
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
                    // Upload Image
                    $path = $request->file($name)->store('imgs', 's3');

                    $pictures = new Pictures();
                    $pictures->mime      = $fileMime;
                    $pictures->pathFile  = self::fileName($path);

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
        } catch (\Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }

    public static function getPicturesByEvents($events_id): array
    {

        $pictures = EventsPictures::where(['events_id' => $events_id]);

        $rows_pictures = array();

        foreach ($pictures->get() as $picture) {
            if ($data_pictures = Pictures::where(['id' => $picture['pictures_id']])->first()) {

                $row_pictures['id'] = $data_pictures['id'];
                $row_pictures['mime'] = $data_pictures['mime'];
                $row_pictures['url'] = url('/imgs') . '/' . $data_pictures['pathFile'];

                array_push($rows_pictures, $row_pictures);
            }
        }

        return $rows_pictures;
    }

    public static function fileName($pathFile)
    {

        $explode_url = explode('/', $pathFile);
        if (!count($explode_url) > 1) {
            return $pathFile;
        }

        return end($explode_url);
    }

    public function showImgs($path)
    {
        try {
            return Storage::disk('s3')->response('imgs/' . $path);
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
        try {
            $users = UsersController::userActive();
            $obj_events_pictures =  EventsPictures::where(['pictures_id' => $id->id])->first();

            if (!$obj_events_pictures) {
                return false;
            }

            if ($users->id !== $obj_events_pictures->users_id) {
                throw new \Exception("Usuário não tem permissão");
            }

            if (!Storage::disk('s3')->delete('imgs/' . $id->pathFile)) {
                throw new \Exception("Não foi possível apagar o arquivo");
            }

            if (!(bool)$obj_events_pictures->destroy($obj_events_pictures->id)) {
                throw new \Exception("Não foi possível apagar arquivo de evento");
            }

            return response()->json(["response" => (bool)$id->destroy($id->id)], 200);
        } catch (\Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }
}
