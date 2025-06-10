<?php

namespace App\Http\Controllers\KelolaAkses;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

 class KelolaAksesController extends Controller
 {
    public function index(){
        return User::all();
    }
}