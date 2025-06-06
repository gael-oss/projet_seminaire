<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Séminaires publiés</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 13px;
            color: #222;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #004080;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        thead {
            background-color: #004080;
            color: white;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ccc;
        }
        tbody tr:nth-child(even) {
            background-color: #f4f7fc;
        }
    </style>
</head>
<body>
    <h1>Liste des séminaires publiés</h1>

    <table>
        <thead>
            <tr>
                <th>Thème</th>
                <th>Date de Présentation</th>
                <th>Présentateur</th>
            </tr>
        </thead>
        <tbody>
            @foreach($seminaires as $seminaire)
                <tr>
                    <td>{{ $seminaire->theme }}</td>
                    <td>{{ \Carbon\Carbon::parse($seminaire->date_presentation)->format('d/m/Y') }}</td>
                    <td>{{ $seminaire->presentateur->name }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
