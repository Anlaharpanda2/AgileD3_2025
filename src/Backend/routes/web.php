<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log; 
Route::get('/', function () {
    Log::info('Root route accessed, returning API status.'); 
    return response()->json([
        'status' => 'success',
        'message' => 'API is running',
        'timestamp' => now()->toDateTimeString(),
        'documentation' => 'Your API documentation link here, if any'
    ]);
});
Route::get('/seeder', function () {
});