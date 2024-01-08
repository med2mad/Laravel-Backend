<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>
<table class="table">
    <thead><tr><th>name</th><th>age</th></tr></thead>
    <body>
        @foreach ($items as $item)
        <tr><td>{{$item->name}}</td><td>{{$item->age}}</td></tr>
        @endforeach
    </body>
</table>
{{$items->links()}}
</body>
</html>