<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Séminaires publiés</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid black; padding: 5px; text-align: left; }
    </style>
</head>
<body>
    <h2>Liste des séminaires publiés</h2>
    <table>
        <thead>
            <tr>
                <th>Thème</th>
                <th>Présentateur</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($seminaires as $s)
            <tr>
                <td>{{ $s->theme }}</td>
                <td>{{ $s->presentateur->name }}</td>
                <td>{{ \Carbon\Carbon::parse($s->date_presentation)->format('d/m/Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
