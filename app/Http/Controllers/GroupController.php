<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function index(Request $request)
    {
        $groups = $request->user()
            ->groups()
            ->with('creator')
            ->get();

        return response()->json([
            'success' => true,
            'groups' => $groups,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $group = Group::create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'created_by' => $request->user()->id,
        ]);

        // Group creator ko automatically member bana do
        $group->members()->attach($request->user()->id);

        return response()->json([
            'success' => true,
            'message' => 'Group created successfully',
            'group' => $group,
        ], 201);
    }
}