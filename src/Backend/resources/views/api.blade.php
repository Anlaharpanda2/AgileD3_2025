{{-- resources/views/api.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Daftar API Routes</title>
  <style>
    body { font-family: sans-serif; padding: 2rem; }
    table { width: 100%; border-collapse: collapse; margin-top: 1rem; }
    th, td { border: 1px solid #ccc; padding: .5rem; text-align: center; }
    th { background: #f4f4f4; }
    td.uri { text-align: left; }
    .yes { color: green; font-weight: bold; }
    a { color: #2c3e50; text-decoration: none; }
    a:hover { text-decoration: underline; }
  </style>
</head>
<body>

  <h1>Daftar Semua API Routes</h1>
  <p><strong>Total API:</strong> {{ $count }}</p>

  <table>
    <thead>
      <tr>
        <th>No</th>
        <th>URI</th>
        <th>GET</th>
        <th>POST</th>
        <th>PUT</th>
        <th>PATCH</th>
        <th>DELETE</th>
      </tr>
    </thead>
    <tbody>
      @foreach($rows as $i => $row)
        <tr>
          <td>{{ $i + 1 }}</td>
          <td class="uri">
            <a href="{{ url($row['uri']) }}" target="_blank">{{ $row['uri'] }}</a>
          </td>
          <td>@if($row['GET']) <span class="yes">&#10003;</span> @endif</td>
          <td>@if($row['POST']) <span class="yes">&#10003;</span> @endif</td>
          <td>@if($row['PUT']) <span class="yes">&#10003;</span> @endif</td>
          <td>@if($row['PATCH']) <span class="yes">&#10003;</span> @endif</td>
          <td>@if($row['DELETE']) <span class="yes">&#10003;</span> @endif</td>
        </tr>
      @endforeach
    </tbody>
  </table>

</body>
</html>
