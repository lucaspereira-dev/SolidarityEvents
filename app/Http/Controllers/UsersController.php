<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Users $users)
    {
        return response()->json(["response" =>users::all()], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Users $users)
    {
        try {
            $validator = Validator::make($request->all(), $users->rules(), $users->messages());

            if ($validator->stopOnFirstFailure()->fails()) {
                return response()->json(["error" => $validator->messages()], 400);
            }

            $users->first_name       = $request->first_name ?? '';
            $users->last_name       = $request->last_name ?? '';
            $users->email           = $request->email  ?? '';
            $users->password        = $request->password;

            if (!$users->save()) {
                return response()->json(["response" => false], 200);
            }

            return response()->json(["response" => $users], 201);
        } catch (\Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Users  $users
     * @return \Illuminate\Http\Response
     */
    public function show(Users $users)
    {
        return response()->json(["response" =>  $users], 200);  
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Users  $users
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Users $users)
    {
        try {

            $data_request = $request->all();
            if (!$users->update($data_request)) {
                return response()->json(["response" => false], 200);
            }

            return response()->json(["response" => $users], 200);
        } catch (\Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Users  $users
     * @return \Illuminate\Http\Response
     */
    public function destroy(Users $users)
    {
        $id = $users->id;
        return response()->json(["response" => (bool)$users->destroy($id)], 200);
    }
}
