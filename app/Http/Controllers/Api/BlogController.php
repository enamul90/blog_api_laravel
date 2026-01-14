<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Blog;
use App\Models\BlogDescription;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    public function store(Request $request)
    {

        $request->validate(
            [
                'title'        => 'required|string',
                'short_dis'    => 'required|string',
                'category_id'  => 'required|exists:categories,id',
                'description'  => 'required|string',
                'cover_image'  => 'nullable|image|mimes:png|max:2048'
            ],
            [
                'title.required'       => 'Title is required',
                'title.string'         => 'Title must be a string',

                'short_dis.required'   => 'Short description is required',
                'short_dis.string'     => 'Short description must be a string',

                'category_id.required' => 'Category is required',
                'category_id.exists'   => 'Selected category is invalid',

                'description.required' => 'Description is required',
                'description.string'   => 'Description must be a string',

                'cover_image.image'    => 'Cover image must be an image file',
                'cover_image.mimes'    => 'Cover image must be a PNG file',
                'cover_image.max'      => 'Cover image size must be less than 2MB'
            ]
        );




        // Image Upload
        $imagePath = null;
        if ($request->hasFile('cover_image')) {
            $imagePath = $request->file('cover_image')
                ->store('blogs', 'public');
        }

        // Blog Table
        $blog = Blog::create([
            'title'       => $request->title,
            'short_dis'   => $request->short_dis,
            'category_id' => $request->category_id,
            'cover_image' => $imagePath
        ]);

        // Description Table
        BlogDescription::create([
            'blog_id'    => $blog->id,
            'description'=> $request->description
        ]);

        return response()->json([
            'status' => true,
            'message'=> 'Blog created successfully',

        ], 201);
    }

    public function index()
    {
        // Fetch all blogs with category info
        $blogs = Blog::with('category')->latest()->get();
    
        // Format response
        $data = $blogs->map(function ($blog) {
            return [
                'id'            => $blog->id,
                'title'         => $blog->title,
                'short_dis'     => $blog->short_dis,
                'category_name' => $blog->category->categoryName ?? null,
                'cover_image'   => $blog->cover_image ? asset('storage/' . $blog->cover_image) : null
            ];
        });
    
        return response()->json([
            'status'  => true,
            'message' => 'Blogs fetched successfully',
            'data'    => $data
        ], 200);
    }

    public function getByCategory($id)
    {
        $blogs = Blog::with('category')->where('category_id', $id)->latest()->get();

        $data = $blogs->map(function ($blog) {
            return [
                'id'            => $blog->id,
                'title'         => $blog->title,
                'short_dis'     => $blog->short_dis,
                'category_name' => $blog->category->categoryName ?? null,
                'cover_image'   => $blog->cover_image ? asset('storage/' . $blog->cover_image) : null
            ];
        });

        return response()->json([
            'status'  => true,
            'message' => 'Blogs fetched successfully',
            'data'    => $data
        ], 200);
    }

    public function getBlogDetails($id)
    {
        // Fetch blog with category and description
        $blog = Blog::with(['category', 'description'])->find($id);

        if (!$blog) {
            return response()->json([
                'status' => false,
                'message' => 'Blog not found',
            ], 404);
        }

        // Format response
        $data = [
            'id'            => $blog->id,
            'title'         => $blog->title,
            'short_dis'     => $blog->short_dis,
            'category_name' => $blog->category->categoryName ?? null,
            'cover_image'   => $blog->cover_image ? asset('storage/' . $blog->cover_image) : null,
            'description'   => $blog->description->description ?? null, // blog_description table
        ];

        return response()->json([
            'status'  => true,
            'message' => 'Blog details fetched successfully',
            'data'    => $data
        ], 200);
    }


    public function update(Request $request, $id)
    {
        // Find the blog
        $blog = Blog::find($id);
        if (!$blog) {
            return response()->json([
                'status' => false,
                'message' => 'Blog not found',
            ], 404);
        }

        // Validate request
        $request->validate(
            [
                'title'        => 'required|string',
                'short_dis'    => 'required|string',
                'category_id'  => 'required|exists:categories,id',
                'description'  => 'required|string',
                'cover_image'  => 'nullable|image|mimes:png|max:2048'
            ],
            [
                'title.required'       => 'Title is required',
                'title.string'         => 'Title must be a string',

                'short_dis.required'   => 'Short description is required',
                'short_dis.string'     => 'Short description must be a string',

                'category_id.required' => 'Category is required',
                'category_id.exists'   => 'Selected category is invalid',

                'description.required' => 'Description is required',
                'description.string'   => 'Description must be a string',

                'cover_image.image'    => 'Cover image must be an image file',
                'cover_image.mimes'    => 'Cover image must be a PNG file',
                'cover_image.max'      => 'Cover image size must be less than 2MB'
            ]
        );

        // Handle cover image update
        if ($request->hasFile('cover_image')) {
            // Delete old image if exists
            if ($blog->cover_image && \Storage::disk('public')->exists($blog->cover_image)) {
                \Storage::disk('public')->delete($blog->cover_image);
            }

            // Store new image
            $blog->cover_image = $request->file('cover_image')->store('blogs', 'public');
        }

        // Update blog table
        $blog->title       = $request->title;
        $blog->short_dis   = $request->short_dis;
        $blog->category_id = $request->category_id;
        $blog->save();

        // Update description table
        if ($blog->description) {
            // Update existing description
            $blog->description->update([
                'description' => $request->description
            ]);
        } else {
            // Create new description if not exists
            BlogDescription::create([
                'blog_id'     => $blog->id,
                'description' => $request->description
            ]);
        }

        return response()->json([
            'status'  => true,
            'message' => 'Blog updated successfully',
            'data'    => [
                'id'            => $blog->id,
                'title'         => $blog->title,
                'short_dis'     => $blog->short_dis,
                'category_name' => $blog->category->categoryName ?? null,
                'cover_image'   => $blog->cover_image ? asset('storage/' . $blog->cover_image) : null,
                'description'   => $blog->description->description ?? null
            ]
        ], 200);
    }


    public function destroy($id)
    {
        // Find the blog
        $blog = Blog::find($id);
    
        if (!$blog) {
            return response()->json([
                'status' => false,
                'message' => 'Blog not found',
            ], 404);
        }
    
        // Delete cover image from storage if exists
        if ($blog->cover_image && \Storage::disk('public')->exists($blog->cover_image)) {
            \Storage::disk('public')->delete($blog->cover_image);
        }
    
        // Delete related description
        if ($blog->description) {
            $blog->description->delete();
        }
    
        // Delete the blog
        $blog->delete();
    
        return response()->json([
            'status'  => true,
            'message' => 'Blog deleted successfully',
        ], 200);
    }




}
