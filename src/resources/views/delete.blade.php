<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Users Data</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" />
</head>
<body>

<h1>
    {{$model}}
</h1>

<a href="/api/framework/view/{{$model}}" class="btn btn-primary">View</a>

<div class="container">
    <div>
        Are you sure you want to delete {{$model}} with id {{$id}}?
    </div>
    <form method="POST" action="/api/framework/delete/{{$model}}/{{$id}}" enctype="multipart/form-data">
        <a href="/api/framework/view/{{$model}}" class="btn btn-primary">
            Cancel
        </a>
        <button type="submit" class="btn btn-danger">
            Delete
        </button>
    </form>
</div>


</body>
</html>
