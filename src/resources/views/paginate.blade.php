<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Users Data</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
{{--    <link href="{{ asset('css/app.css') }}" rel="stylesheet" />--}}
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>

<h1>
    {{$model}}
</h1>

<a href="/api/framework/create/{{$model}}" class="btn btn-primary">Create</a>

<table class="table table-striped">
    <thead>
    <tr>
        <th>Edit</th>
        <th>ID</th>
        @foreach($fields as $field)
        <th>{{$field}}</th>
        @endforeach
    </tr>
    </thead>
    <tbody>
    @foreach($resources as $resource)
        <tr>
            <td>
                <a class="btn btn-primary" href="/api/framework/edit/{{$model}}/{{ $resource->id }}">Edit</a>
                <a class="btn btn-danger" href="/api/framework/delete/{{$model}}/{{ $resource->id }}">Delete</a>
            </td>
            <td>{{ $resource->id }}</td>
            @foreach($fields as $field)
            <td>{{$resource->$field}}</td>
            @endforeach
        </tr>
    @endforeach
    </tbody>
</table>

</body>
</html>
