<?php

namespace App\Http\Controllers;

use App\Models\vania;
use Illuminate\Http\Request;

 class VaniaController extends Controller
 {
     public function index()
     {
         return vania::all();
    }
}