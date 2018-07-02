<?php

namespace App\Http\Controllers;

use App\Publication;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Validator;

class PublicationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $publications = Publication::all();
        return response()->json([
            'data' => $publications
        ], 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validationRules = [
            'title' => 'required|min:1|max:30',
            'content' => 'required|min:10|unique:publications',
            'owner_id' => 'required|exists:users,id',
            'description' => 'max:255'
        ];

        $pubValidator = Validator::make($request->all(), $validationRules);

        if($pubValidator->fails())
        {
            return response()->json([
                'error' => 'true',
                'message' => $pubValidator->messages()
            ], 400);
        }

        $publication = Publication::create($request->all());
        return response()->json([
            'message' => 'Publication created',
            'data' => $publication
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  Publication  $publication
     * @return \Illuminate\Http\Response
     */
    public function show(Publication $publication)
    {
        return response()->json([
                'data' => $publication
            ], 200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Publication  $publication
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Publication $publication)
    {
        $validationRules = [
            'title' => 'required|min:1|max:30',
            'content' => 'required|min:10|unique:publications,content,' . $publication->id,
            'owner_id' => 'required|exists:users,id',
            'description' => 'max:255'
        ];

        $pubValidator = Validator::make($request->all(), $validationRules);

        if($pubValidator->fails())
        {
            return response()->json([
                'error' => 'true',
                'message' => $pubValidator->messages()
            ], 400);
        }

        $publication ->update($request->all());
        return response()->json([
            'message' => 'Publication updated',
            'data' => $publication
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Publication $publication
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Publication $publication)
    {

        $publication->delete();
        return response()->json([
            'message' => 'Publication deleted',
            'data' => $publication
        ], 200);
    }
}
