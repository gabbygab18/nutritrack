<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Goal;
use Illuminate\Http\Request;

class GoalController extends Controller
{
    public function show(Request $request)
    {
        $goal = Goal::firstOrCreate(
            ['user_id' => $request->user()->id],
            ['calories' => 2000, 'protein' => 120]
        );

        return response()->json($goal);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'calories' => 'required|integer|min:1',
            'protein' => 'required|integer|min:1',
        ]);

        $goal = Goal::updateOrCreate(
            ['user_id' => $request->user()->id],
            $data
        );

        return response()->json($goal);
    }
}
