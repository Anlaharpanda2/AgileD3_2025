<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;

Route::get('/users', function () {
    return [
        ['id' => 1, 'name' => 'Frontend ketemu Backend! 🎉'],
        ['id' => 2, 'name' => 'Laravel + Vue sukses!'],
    ];
});

Route::get('/test', function () {
    return ['test' => 'oke'];
});
