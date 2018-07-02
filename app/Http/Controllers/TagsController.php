<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TagsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = Tag::all();
        return response()->json([
            'data' => $tags
        ], 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validationRules = [
            'name' => 'required|min:1|max:40|unique:tags,name',
            'publication_id' => 'required|exists:publications,id'
        ];

        $tagValidator = Validator::make($request->all(), $validationRules);

        if($tagValidator->fails())
        {
            return response()->json([
                'error' => 'true',
                'message' => $tagValidator->messages()
            ], 400);
        }

        $tag = Tag::create($request->all());
        $tag->publications()->attach($request->get('publication_id'));

        return response()->json([
            'message' => 'Tag created',
            'data' => $tag
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $tag)
    {
        return response()->json([
            "data" => $tag
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tag $tag)
    {
        $validationRules = [
            'name' => 'required|min:1|max:40|unique:tags,name,' . $tag->id,
            'publication_id' => 'required|exists:publications,id'
        ];

        $tagValidator = Validator::make($request->all(), $validationRules);

        if($tagValidator->fails())
        {
            return response()->json([
                'error' => 'true',
                'message' => $tagValidator->messages()
            ], 400);
        }

        $tag->update($request->all());
        $tag->publications()->sync($request->get('publication_id'));

        return response()->json([
            'message' => 'Tag updated',
            'data' => $tag
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Tag $tag
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Tag $tag)
    {
        $tag->delete();
        return response()->json([
            'message' => 'Tag deleted',
            'data' => $tag
        ]);
    }
}
