<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Excel Values</title>
</head>
<body>
    <h1>Display Excel Values</h1>

    <table border="1">
        <thead>
            
        </thead>
        <tbody>
            @foreach ($data as $row)
                <tr>
                    @foreach ($row as $rows)
                        <td>{{$rows}}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>