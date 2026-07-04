<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Goal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function user(Request $request)
    {
        return response()->json($request->user());
    }

    // app/Http/Controllers/Api/AuthController.php

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:4',

            // New fields
            'height' => 'required|numeric|min:50|max:300',
            'weight' => 'required|numeric|min:20|max:500',
            'age' => 'required|integer|min:10|max:120',
            'body_type' => 'required|string|in:ectomorph,mesomorph,endomorph',
            'goal' => 'required|string|in:stay,bulk,cut',
            'exercise_intensity' => 'required|string|in:sedentary,light,moderate,heavy,athlete',
        ]);

        // Compute BMR (Mifflin-St Jeor)
        $bmr = $this->computeBMR($data['weight'], $data['height'], $data['age'], $request->input('gender', 'male'));

        // Activity factor
        $activityFactors = [
            'sedentary' => 1.2,
            'light' => 1.375,
            'moderate' => 1.55,
            'heavy' => 1.725,
            'athlete' => 1.9,
        ];
        $tdee = $bmr * $activityFactors[$data['exercise_intensity']];

        // Suggested calories based on goal
        $suggestedCalories = match ($data['goal']) {
            'bulk' => $tdee + 500,
            'cut' => $tdee - 500,
            default => $tdee,
        };

        // Protein: 1.6–2.2 g/kg, we'll use 1.8
        $suggestedProtein = round($data['weight'] * 1.8);

        // Carbs and fats (rough allocation)
        $suggestedFat = round(($suggestedCalories * 0.25) / 9);
        $suggestedCarbs = round(($suggestedCalories - ($suggestedProtein * 4) - ($suggestedFat * 9)) / 4);
        $suggestedCarbs = max($suggestedCarbs, 50); // safety

        // Create user
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'height' => $data['height'],
            'weight' => $data['weight'],
            'age' => $data['age'],
            'body_type' => $data['body_type'],
            'goal' => $data['goal'],
            'exercise_intensity' => $data['exercise_intensity'],
        ]);

        // Create goals
        Goal::create([
            'user_id' => $user->id,
            'calories' => $suggestedCalories,
            'protein' => $suggestedProtein,
            'carbs' => $suggestedCarbs,
            'fat' => $suggestedFat,
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return response()->json([
            'user' => $user,
            'suggested' => [
                'bmr' => round($bmr),
                'tdee' => round($tdee),
                'calories' => $suggestedCalories,
                'protein' => $suggestedProtein,
                'carbs' => $suggestedCarbs,
                'fat' => $suggestedFat,
            ]
        ]);
    }

    private function computeBMR($weightKg, $heightCm, $age, $gender = 'male')
    {
        if ($gender === 'female') {
            return (10 * $weightKg) + (6.25 * $heightCm) - (5 * $age) - 161;
        }
        return (10 * $weightKg) + (6.25 * $heightCm) - (5 * $age) + 5;
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'The provided credentials are incorrect.'], 422);
        }

        $request->session()->regenerate();

        return response()->json(Auth::user());
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->noContent();
    }
}
