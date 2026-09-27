<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Park;
use Illuminate\Http\Request;

class ParkController extends Controller
{
    /*
     * GET /api/v1/parks
     */
   public function index()
    {
        $parks = Park::latest()->get();

        return response()->json([
            'success' => true,
            'data' => $parks
        ]);
    }

    /**
     * POST /api/v1/parks
     */
    public function store(Request $request)
    {
        $request->validate([
            'park_name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
        ]);

        $park = Park::create([
            'park_name' => $request->park_name,
            'location' => $request->location,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Park created successfully',
            'data' => $park
        ], 201);
    }

    /**
     * PUT /api/v1/parks/{id}
     */
    public function update(Request $request, $id)
    {
        $park = Park::findOrFail($id);

        $request->validate([
            'park_name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
        ]);

        $park->update([
            'park_name' => $request->park_name,
            'location' => $request->location,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Park updated successfully',
            'data' => $park
        ]);
    }

    /**
     * DELETE /api/v1/parks/{id}
     */
    public function destroy($id)
    {
        $park = Park::findOrFail($id);

        $park->delete();

        return response()->json([
            'success' => true,
            'message' => 'Park deleted successfully'
        ]);
    }
} 
