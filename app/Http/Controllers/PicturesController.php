<?php

namespace App\Http\Controllers;

use App\Models\Pictures;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PicturesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return response()->json([Pictures::all()], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Pictures $pictures)
    {
        
        try {

            $validator = Validator::make($request->all(), $pictures->rules(), $pictures->messages());

            if ($validator->stopOnFirstFailure()->fails()) {
                return response()->json(["error" => $validator->messages()], 400);
            }

            $pictures->hash         = $request->hash ?? '';
            $pictures->mimo         = $request->mimo ?? '';
            $pictures->dir          = $request->dir  ?? '';
            $pictures->title        = $request->title  ?? '';
            $pictures->description  = $request->description  ?? '';

            if (!$pictures->save()) {
                return response()->json(["response" => false], 200);
            }

            return response()->json(["response" => $pictures], 201);
        } catch (\Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pictures  $pictures
     * @return \Illuminate\Http\Response
     */
    public function show(Pictures $pictures)
    {
        return response()->json(["response" => $pictures], 200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pictures  $pictures
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pictures $pictures)
    {
        try {

            $data_request = $request->all();
            if (!$pictures->update($data_request)) {
                return response()->json(["response" => false], 200);
            }

            return response()->json(["response" => $pictures], 200);
        } catch (\Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pictures  $pictures
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pictures $pictures)
    {
        $id = $pictures->id;
        return response()->json(["response" => (bool)$pictures->destroy($id)], 200);
    }
}
