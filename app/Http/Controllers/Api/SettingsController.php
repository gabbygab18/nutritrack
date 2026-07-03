<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PhysiquePhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SettingsController extends Controller
{
    public function updateProfile(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'avatar' => 'nullable|string',
        ]);

        $user = $request->user();
        $user->update($data);

        return response()->json($user);
    }

    public function updatePassword(Request $request)
    {
        $data = $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = $request->user();

        if (!Hash::check($data['current_password'], $user->password)) {
            return response()->json(['message' => 'Current password is incorrect.'], 422);
        }

        $user->update(['password' => Hash::make($data['password'])]);

        return response()->json(['message' => 'Password updated.']);
    }

    public function physiquePhotos(Request $request)
    {
        return response()->json(
            $request->user()->physiquePhotos()->orderBy('timestamp', 'desc')->get()
        );
    }

    public function storePhysiquePhoto(Request $request)
    {
        $data = $request->validate([
            'photo' => 'required|string',
            'notes' => 'nullable|string|max:255',
            'date' => 'required|date',
            'timestamp' => 'required|integer',
        ]);

        $photo = PhysiquePhoto::create(array_merge($data, ['user_id' => $request->user()->id]));

        return response()->json($photo);
    }

    public function destroyPhysiquePhoto(Request $request, PhysiquePhoto $physiquePhoto)
    {
        if ($physiquePhoto->user_id !== $request->user()->id) {
            abort(403);
        }
        $physiquePhoto->delete();
        return response()->noContent();
    }
}
