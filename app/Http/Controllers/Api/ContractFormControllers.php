<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContactForm;

class ContractFormControllers extends Controller
{
    public function store(Request $request)
    {
        $request->validate(
            [
                'name'  => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'required|string|max:20',
                'city'  => 'required|string|max:255',
                'dis'   => 'required|string',
            ],
            [
                'name.required'  => 'Name is required',
                'name.string'    => 'Name must be a string',
                'name.max'       => 'Name cannot exceed 255 characters',

                'email.required' => 'Email is required',
                'email.email'    => 'Please enter a valid email address',
                'email.max'      => 'Email cannot exceed 255 characters',

                'phone.required' => 'Phone number is required',
                'phone.string'   => 'Phone number must be a string',
                'phone.max'      => 'Phone number cannot exceed 20 characters',

                'city.required' => 'City is required',
                'city.string'   => 'City must be a string',
                'city.max'      => 'City cannot exceed 255 characters',

                'dis.required' => 'Description is required',
                'dis.string'   => 'Description must be a string',
            ]
        
        );


        $createForm = ContactForm::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Contract form created successfully',
            'data' => $createForm
        ], 201);
    }

    public function index(Request $request)
    {
        $page  = $request->query('page', 1);   // default page = 1
        $limit = $request->query('limit', 10); // default limit = 10
    
        $skip = ($page - 1) * $limit;
    
        $total = ContactForm::count();
    
        $contactForm = ContactForm::skip($skip)
                            ->take($limit)
                            ->orderBy('id', 'desc')
                            ->get();
    
        return response()->json([
            'status' => true,
            'message' => 'Contact form list successfully',
            'pagination' => [
                'total' => $total,
                'page' => (int)$page,
                'limit' => (int)$limit,
                'total_pages' => ceil($total / $limit)
            ],
            'data' => $contactForm
        ], 200);
    }

}
