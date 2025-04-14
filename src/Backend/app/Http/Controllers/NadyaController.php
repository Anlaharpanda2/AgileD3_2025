<?php

namespace App\Http\Controllers;

use App\Models\nadya;
use Illuminate\Http\Request;

 class NadyaController extends Controller
 {
     public function index()
     {
         return nadya::all();
     }
}
