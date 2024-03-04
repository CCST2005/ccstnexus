<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excel Upload Form</title>
</head>
<body>
    <h1>Excel Upload Form</h1>

    <form action="{{ route('process.excel') }}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="file" name="file" accept=".xlsx, .xls, .csv">
        <button type="submit">Upload</button>
    </form>
</body>
</html>
