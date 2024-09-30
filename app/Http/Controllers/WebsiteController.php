<?php namespace App\Http\Controllers;

use App\Models\Website;
use Illuminate\Http\Request;

class WebsiteController extends Controller
{
    // Store a new website
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'website_name' => 'required|string|max:255',
            'website_url' => 'required|url|max:255',
        ]);

        $website = Website::create($validatedData);

        return response()->json([
            'message' => 'Website created successfully',
            'website' => $website,
        ], 201);
    }

    // Get all websites
    public function index()
    {
        $websites = Website::all();
        return response()->json($websites);
    }

    // Get a specific website by ID
    public function show($id)
    {
        $website = Website::findOrFail($id);
        return response()->json($website);
    }

}
