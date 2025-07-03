<?php

namespace App\Http\Controllers\Pretest;

use App\Http\Controllers\Controller;
use App\Models\PretestScore;
use Illuminate\Http\Request;

class PretestScoreController extends Controller
{
    public function index()
    {
        // Mengambil semua data pretest score beserta data pengguna yang terkait
        return PretestScore::with('user')->get();
    }
}
