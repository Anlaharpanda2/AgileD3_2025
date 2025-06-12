<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
Route::get('/', function () {
    return view('welcome');
});
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
    $tmp = [];
    foreach ($allRoutes as $route) {
        $uri = $route->uri();
        if (Str::startsWith($uri, 'api/')) {
            foreach ($route->methods() as $method) {
                if (in_array($method, ['HEAD', 'OPTIONS'])) {
                    continue;
                }
                $tmp[$uri][] = $method;
            }
        }
    }
    $rows = [];
    foreach ($tmp as $uri => $methods) {
        $rows[] = [
            'uri'    => '/'.$uri,
            'GET'    => in_array('GET', $methods),
            'POST'   => in_array('POST', $methods),
            'PUT'    => in_array('PUT', $methods),
            'PATCH'  => in_array('PATCH', $methods),
            'DELETE' => in_array('DELETE', $methods),
        ];
    }
    $count = count($rows);
    return view('api', [
        'rows'  => $rows,
        'count' => $count,
    ]);
});
