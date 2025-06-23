{{-- resources/views/api.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar API Routes</title>
    <style>
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            padding: 2rem; 
            background-color: #f8f9fa;
            color: #333;
        }
        
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem;
            border-radius: 10px;
            margin-bottom: 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .header h1 {
            margin: 0 0 1rem 0;
            font-size: 2.5rem;
        }
        
        .stats {
            display: flex;
            gap: 2rem;
            flex-wrap: wrap;
        }
        
        .stat-card {
            background: rgba(255, 255, 255, 0.2);
            padding: 1rem 1.5rem;
            border-radius: 8px;
            backdrop-filter: blur(10px);
        }
        
        .stat-number {
            font-size: 2rem;
            font-weight: bold;
            display: block;
        }
        
        .stat-label {
            font-size: 0.9rem;
            opacity: 0.9;
        }
        
        table { 
            width: 100%; 
            border-collapse: collapse; 
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        th, td { 
            border: 1px solid #e0e0e0; 
            padding: 1rem 0.75rem; 
            text-align: center; 
        }
        
        th { 
            background: #f8f9fa; 
            font-weight: 600;
            color: #495057;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }
        
        td.uri { 
            text-align: left; 
            font-family: 'Courier New', monospace;
            background-color: #f8f9fa;
            font-weight: 500;
        }
        
        .method-check { 
            color: #28a745; 
            font-weight: bold; 
            font-size: 1.2rem;
        }
        
        .method-cross {
            color:rgb(255, 255, 255);
            font-size: 1rem;
        }
        
        a { 
            color:rgb(55, 55, 55); 
            text-decoration: none; 
            transition: color 0.2s;
            font-weight: 600;
        }
        
        a:hover { 
            color: #0056b3;
            text-decoration: underline; 
        }
        
        tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        
        tr:hover {
            background-color: #e8f4fd;
        }
        
        .no-api {
            text-align: center;
            padding: 3rem;
            color: #6c757d;
            font-style: italic;
        }
        
        @media (max-width: 768px) {
            body { padding: 1rem; }
            .header { padding: 1.5rem; }
            .header h1 { font-size: 2rem; }
            .stats { gap: 1rem; }
            table { font-size: 0.9rem; }
            th, td { padding: 0.5rem; }
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>Daftar API Routes</h1>
        <div class="stats">
            <div class="stat-card">
                <span class="stat-number">{{ $totalEndpoints }}</span>
                <span class="stat-label">Total API Endpoints</span>
            </div>
            <div class="stat-card">
                <span class="stat-number">{{ number_format(($totalEndpoints / max($totalUris, 1)), 1) }}</span>
                <span class="stat-label">Avg Methods per URI</span>
            </div>
        </div>
    </div>

    @if(count($rows) > 0)
        <table>
            <thead>
                <tr>
                    <th style="width: 50px;">No</th>
                    <th style="min-width: 200px;">URI</th>
                    <th style="width: 80px;">GET</th>
                    <th style="width: 80px;">POST</th>
                    <th style="width: 80px;">PUT</th>
                    <th style="width: 80px;">PATCH</th>
                    <th style="width: 80px;">DELETE</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rows as $i => $row)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td class="uri">
                            <a href="{{ url($row['uri']) }}" target="_blank" title="Klik untuk membuka di tab baru">
                                {{ $row['uri'] }}
                            </a>
                        </td>
                        <td>
                            @if($row['GET']) 
                                <span class="method-check">✓</span> 
                            @else 
                                <span class="method-cross"></span>
                            @endif
                        </td>
                        <td>
                            @if($row['POST']) 
                                <span class="method-check">✓</span> 
                            @else 
                                <span class="method-cross"></span>
                            @endif
                        </td>
                        <td>
                            @if($row['PUT']) 
                                <span class="method-check">✓</span> 
                            @else 
                                <span class="method-cross"></span>
                            @endif
                        </td>
                        <td>
                            @if($row['PATCH']) 
                                <span class="method-check">✓</span> 
                            @else 
                                <span class="method-cross"></span>
                            @endif
                        </td>
                        <td>
                            @if($row['DELETE']) 
                                <span class="method-check">✓</span> 
                            @else 
                                <span class="method-cross"></span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="no-api">
            <h3>Tidak ada API routes yang ditemukan</h3>
            <p>Pastikan Anda memiliki routes yang dimulai dengan 'api/' di file routes/api.php</p>
        </div>
    @endif

</body>
</html>