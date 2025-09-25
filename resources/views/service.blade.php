<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Liste de nos services :</h1>
    @foreach($services as $service)
        <p>{{ $service->nom }}</p>
    @endforeach
    
</body>
</html>