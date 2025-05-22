<?php

namespace App\Http\Controllers;

use App\Models\Pendaftar;
use Illuminate\Http\Request;

 class NadyaController extends Controller
 {
     public function index()
     {
         return Pendaftar::all();
 }
}
