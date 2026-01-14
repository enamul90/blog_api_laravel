<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\hero_content;

class HeroContentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate(
            [
                'title'          => 'required|string|max:255',
                'boldTitle'      => 'required|string|max:255',
                'dis'            => 'required|string',
                'videoButtonUrl' => 'required|string'
            ],
            [
                'title.required'          => 'Title is required',
                'title.string'            => 'Title must be a string',
                'title.max'               => 'Title cannot exceed 255 characters',

                'boldTitle.required'      => 'Bold Title is required',
                'boldTitle.string'        => 'Bold Title must be a string',
                'boldTitle.max'           => 'Bold Title cannot exceed 255 characters',

                'dis.required'            => 'Description is required',
                'dis.string'              => 'Description must be a string',

                'videoButtonUrl.required' => 'Video Button URL is required',
                'videoButtonUrl.string'   => 'Video Button URL must be a string'
            ]
        );


        $heroContent = hero_content::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Hero content created successfully',
            'data' => $heroContent
        ], 201);
    }

    public function index (){

       $heroContent = hero_content::get();

            return response()->json([
            'status' => true,
            'message' => 'Hero content list successfuly',
            'data' => $heroContent
        ], 200);


    }

    public function destroy($id)
    {
        // Find the blog
        $heroContent = hero_content::find($id);
    
        if (!$heroContent) {
            return response()->json([
                'status' => false,
                'message' => 'Blog not found',
            ], 404);
        }
    
    
        // Delete the blog
        $heroContent->delete();
    
        return response()->json([
            'status'  => true,
            'message' => 'Header Content deleted successfully',
            'data' => $heroContent,
        ], 200);
    }

    public function update(Request $request, $id)
    {
        // Find the hero content
        $heroContent = hero_content::find($id);
    
        if (!$heroContent) {
            return response()->json([
                'status' => false,
                'message' => 'Header Content not found',
            ], 404);
        }
    
    
        // Update data
        $heroContent->update($request->only([
            'title',
            'boldTitle',
            'dis',
            'videoButtonUrl',
        ]));
    
        return response()->json([
            'status'  => true,
            'message' => 'Header Content updated successfully',
            'data'    => $heroContent,
        ], 200);
    }

    public function getById( $id)
    {
        // Find the hero content
        $heroContent = hero_content::find($id);
    
        if (!$heroContent) {
            return response()->json([
                'status' => false,
                'message' => 'Header Content not found',
            ], 404);
        }
    

        return response()->json([
            'status'  => true,
            'message' => 'Header Content updated successfully',
            'data'    => $heroContent,
        ], 200);
    }


}

