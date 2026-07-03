<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Entry;
use Illuminate\Http\Request;

class EntryController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->user()->entries()->orderBy('timestamp', 'desc');

        if ($request->filled('date')) {
            $query->where('date', $request->query('date'));
        }

        return response()->json($query->get());
    }

    public function show(Request $request, Entry $entry)
    {
        $this->authorizeEntry($request->user()->id, $entry);
        return response()->json($entry);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id' => 'required|string',
            'name' => 'required|string|max:255',
            'meal' => 'required|string|max:255',
            'servings' => 'required|numeric|min:0.1',
            'serving_unit' => 'required|string|max:255',
            'per_calories' => 'required|numeric|min:0',
            'per_protein' => 'required|numeric|min:0',
            'per_carbs' => 'required|numeric|min:0',
            'per_fat' => 'required|numeric|min:0',
            'calories' => 'required|numeric|min:0',
            'protein' => 'required|numeric|min:0',
            'carbs' => 'required|numeric|min:0',
            'fat' => 'required|numeric|min:0',
            'photo' => 'nullable|string',
            'date' => 'required|date',
            'timestamp' => 'required|integer',
        ]);

        $entry = Entry::create(array_merge($data, ['user_id' => $request->user()->id]));

        return response()->json($entry);
    }

    public function update(Request $request, Entry $entry)
    {
        $this->authorizeEntry($request->user()->id, $entry);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'meal' => 'required|string|max:255',
            'servings' => 'required|numeric|min:0.1',
            'serving_unit' => 'required|string|max:255',
            'per_calories' => 'required|numeric|min:0',
            'per_protein' => 'required|numeric|min:0',
            'per_carbs' => 'required|numeric|min:0',
            'per_fat' => 'required|numeric|min:0',
            'calories' => 'required|numeric|min:0',
            'protein' => 'required|numeric|min:0',
            'carbs' => 'required|numeric|min:0',
            'fat' => 'required|numeric|min:0',
            'photo' => 'nullable|string',
            'date' => 'required|date',
            'timestamp' => 'required|integer',
        ]);

        $entry->update($data);

        return response()->json($entry);
    }

    public function destroy(Request $request, Entry $entry)
    {
        $this->authorizeEntry($request->user()->id, $entry);
        $entry->delete();
        return response()->noContent();
    }

    protected function authorizeEntry(int $userId, Entry $entry)
    {
        if ($entry->user_id !== $userId) {
            abort(403);
        }
    }
}
