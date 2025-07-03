<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CombinedScore;
use Illuminate\Http\Request;

class CombinedScoreController extends Controller
{
    public function index()
    {
        return response()->json(CombinedScore::all());
    }

    public function showByNik(string $nik)
    {
        $score = CombinedScore::where('user_nik', $nik)->first();

        if (!$score) {
            return response()->json(['message' => 'Score not found for this NIK.'], 404);
        }

        return response()->json($score);
    }
}
