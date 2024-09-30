<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Subscription;
use App\Models\Website;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'sub_name' => 'required|string|max:255',
            'sub_email' => 'required|email',
            'website_id' => 'required|exists:websites,website_id',
        ]);
        $validatedData = $request->validate([
            'website_id' => 'required|exists:websites,website_id',
            'sub_name' => 'required|string',
            'sub_email' => 'required|email',
        ]);

        $website = Website::find($validatedData['website_id']);

        if (!$website) {
            return response()->json([
                'error' => 'Website not found.'
            ], 404);
        }

        $subscription = Subscription::create($request->all());

        return response()->json(['message' => 'Subscription created successfully', 'subscription' => $subscription], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
