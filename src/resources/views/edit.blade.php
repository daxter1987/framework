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
    <form method="POST" action="/api/framework/patch/{{$model}}/{{$id}}" enctype="multipart/form-data">
        @foreach($fields as $field)
            @if($field['data_type'] === 'bigint')
                <div class="form-group">
                    <label for="{{$field['column_name']}}">{{$field['column_name']}}</label>
                    <select class="form-control" id="{{$field['column_name']}}" name="{{$field['column_name']}}">
                        @foreach($field['options'] as $option)
                            @if($field['value'] == $option['id'])
                                <option value="{{$option['id']}}" selected>{{$option['name']}}{{$option['title']}}</option>
                            @else
                                <option value="{{$option['id']}}">{{$option['name']}}{{$option['title']}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            @elseif($field['data_type'] === 'int' || $field['data_type'] === 'double')
                <div class="form-group">
                    <label for="{{$field['column_name']}}">{{$field['column_name']}}</label>
                    <input value="{{$field['value']}}" type="number" class="form-control" id="{{$field['column_name']}}" name="{{$field['column_name']}}" placeholder="Enter {{$field['column_name']}}">
                </div>
            @elseif(strpos($field['column_name'], 's3_url'))
                <div class="form-group">
                    <label for="{{$field['column_name']}}">{{$field['column_name']}}</label>
                    <input type="file" class="form-control-file" id="{{$field['column_name']}}" name="{{$field['column_name']}}">
                </div>
            @elseif($field['data_type'] === 'tinyint')
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="{{$field['value']}}" id="{{$field['column_name']}}" name="{{$field['column_name']}}">
                    <label class="form-check-label" for="{{$field['column_name']}}">
                        {{$field['column_name']}}
                    </label>
                </div>
            @else
                <div class="form-group">
                    <label for="{{$field['column_name']}}">{{$field['column_name']}}</label>
                    <input value="{{$field['value']}}" type="text" class="form-control" id="{{$field['column_name']}}" name="{{$field['column_name']}}" placeholder="Enter {{$field['column_name']}}">
                </div>
            @endif
        @endforeach
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

</body>
</html>
