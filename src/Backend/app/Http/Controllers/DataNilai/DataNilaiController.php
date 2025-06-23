<?php

namespace App\Http\Controllers\DataNilai;

use App\Http\Controllers\Controller;
use App\Models\DataNilai;
use Illuminate\Http\Request;

class DataNilaiController extends Controller
{
    public function index()
    {
        return DataNilai::all();
    }
}