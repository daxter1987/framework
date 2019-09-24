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
                <div class="form-group">
                    <label for="{{$field['column_name']}}">{{$field['column_name']}}</label>
                    <select class="form-control" id="{{$field['column_name']}}" name="{{$field['column_name']}}">
                        @if($field['value'] === 1)
                            <option value="1" selected>True</option>
                        @else
                            <option value="1">True</option>
                        @endif
                        @if($field['value'] === 0)
                            <option value="0" selected>False</option>
                        @else
                            <option value="0">False</option>
                        @endif
                    </select>
                </div>
            @elseif($field['data_type'] === 'longtext')
                <div class="form-group">
                    <label for="{{$field['column_name']}}">{{$field['column_name']}}</label>
                    <textarea class="form-control" id="{{$field['column_name']}}" name="{{$field['column_name']}}" placeholder="Enter {{$field['column_name']}}">
                        {{$field['value']}}
                    </textarea>
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
