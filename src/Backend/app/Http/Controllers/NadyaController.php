<?php

namespace App\Http\Controllers;

use App\Models\pendaftar;
use Illuminate\Http\Request;

 class NadyaController extends Controller
 {
     public function index()
     {
         return pendaftar::all();
 }
}
