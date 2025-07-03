<?php

namespace App\Http\Controllers\Posttest;

use App\Http\Controllers\Controller;
use App\Models\PosttestScore;
use Illuminate\Http\Request;

class PosttestScoreController extends Controller
{
    public function index()
    {
        // Mengambil semua data posttest score beserta data pengguna yang terkait
        return PosttestScore::with('user')->get();
    }
}
