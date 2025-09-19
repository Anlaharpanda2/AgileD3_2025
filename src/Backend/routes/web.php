<?php
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
Route::get('/seeder', function () {
    $directory = database_path('seeders');
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));
    $phpFiles = new RegexIterator($iterator, '/^.+\.php$/i', RecursiveRegexIterator::GET_MATCH);
    $classes = [];
    foreach ($phpFiles as $file) {
        if (str_ends_with($file[0], 'DatabaseSeeder.php')) {
            continue;
        }
        $content = file_get_contents($file[0]);
        if (preg_match('/class\s+(\w+)\s+extends\s+Seeder/', $content, $classMatch)) {
            $className = $classMatch[1];
            $classes[] = $className . '::class,';
        }
    }
    sort($classes);
    $indentedOutput = array_map(fn($line) => '            ' . $line, $classes);
    $finalOutput = implode("\n", $indentedOutput);
    return response("<pre>$finalOutput</pre>");
});
Route::get('/', function () {
    $allRoutes = Route::getRoutes();
    $apiRoutes = [];
    $totalApiCount = 0;
    foreach ($allRoutes as $route) {
        $uri = $route->uri();
        if (Str::startsWith($uri, 'api/')) {
            foreach ($route->methods() as $method) {
                if (in_array($method, ['HEAD', 'OPTIONS'])) {
                    continue;
                }
                $totalApiCount++;
                if (!isset($apiRoutes[$uri])) {
                    $apiRoutes[$uri] = [
                        'GET' => false,
                        'POST' => false,
                        'PUT' => false,
                        'PATCH' => false,
                        'DELETE' => false,
                    ];
                }
                $apiRoutes[$uri][$method] = true;
            }
        }
    }
    $rows = [];
    foreach ($apiRoutes as $uri => $methods) {
        $rows[] = [
            'uri' => '/' . $uri,
            'GET' => $methods['GET'],
            'POST' => $methods['POST'],
            'PUT' => $methods['PUT'],
            'PATCH' => $methods['PATCH'],
            'DELETE' => $methods['DELETE'],
        ];
    }
    return view('api', [
        'rows' => $rows,
        'totalEndpoints' => $totalApiCount, 
        'totalUris' => count($rows), 
    ]);
});

Route::get('/debug-all-routes', function () {
    try {
        Artisan::call('route:list');
        return '<pre>' . Artisan::output() . '</pre>';
    } catch (\Exception $e) {
        return "Error running route:list: " . $e->getMessage();
    }
});