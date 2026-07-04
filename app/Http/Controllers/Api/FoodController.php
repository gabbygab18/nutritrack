<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Food;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class FoodController extends Controller
{
    /**
     * GET /api/foods/search?q=adobo
     * Returns local Filipino-dish matches first, then USDA results as a
     * supplement (skipped entirely if local already has enough matches).
     */
    public function search(Request $request)
    {
        $query = trim((string) $request->query('q', ''));

        if ($query === '') {
            return response()->json(['local' => [], 'usda' => []]);
        }

        $normalized = Str::of($query)->lower()->ascii()->trim()->value();

        $local = Food::query()
            ->where('name_normalized', 'like', '%' . $normalized . '%')
            ->orWhereJsonContains('aliases', $normalized)
            ->orderBy('name')
            ->limit(15)
            ->get()
            ->map(fn (Food $f) => $this->formatLocal($f))
            ->values();

        // Enough local matches (e.g. "adobo") — no need to hit USDA at all.
        if ($local->count() >= 3) {
            return response()->json(['local' => $local, 'usda' => []]);
        }

        return response()->json([
            'local' => $local,
            'usda' => $this->searchUsda($query),
        ]);
    }

    protected function formatLocal(Food $food): array
    {
        return [
            'source' => 'local',
            'id' => 'local-' . $food->id,
            'name' => $food->name,
            'brand' => $food->category,
            'serving_description' => $food->serving_description,
            'calories' => $food->calories,
            'protein' => $food->protein,
            'carbs' => $food->carbs,
            'fat' => $food->fat,
        ];
    }

    protected function searchUsda(string $query): array
    {
        $apiKey = config('services.usda.key');
        if (!$apiKey) {
            return [];
        }

        $response = Http::timeout(6)->get('https://api.nal.usda.gov/fdc/v1/foods/search', [
            'api_key' => $apiKey,
            'query' => $query,
            'pageSize' => 12,
            'dataType' => 'Foundation,SR Legacy,Branded',
        ]);

        if (!$response->ok()) {
            return [];
        }

        $foods = $response->json('foods', []);

        return collect($foods)->map(function ($food) {
            $nutrients = collect($food['foodNutrients'] ?? []);

            $get = function ($name, $unit = null) use ($nutrients) {
                $match = $nutrients->first(function ($n) use ($name, $unit) {
                    return ($n['nutrientName'] ?? null) === $name
                        && (!$unit || ($n['unitName'] ?? null) === $unit);
                });
                return $match['value'] ?? 0;
            };

            return [
                'source' => 'usda',
                'id' => 'usda-' . $food['fdcId'],
                'name' => Str::title(strtolower($food['description'] ?? 'Unknown food')),
                'brand' => $food['brandOwner'] ?? $food['brandName'] ?? '',
                'serving_description' => '100 g',
                'calories' => round($get('Energy', 'KCAL'), 1),
                'protein' => round($get('Protein'), 1),
                'carbs' => round($get('Carbohydrate, by difference'), 1),
                'fat' => round($get('Total lipid (fat)'), 1),
            ];
        })->values()->all();
    }
}
