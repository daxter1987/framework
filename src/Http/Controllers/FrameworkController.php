<?php

namespace daxter1987\Framework\Controllers;

use App\Http\Controllers\Controller;
use daxter1987\AmazonHelpers\AmazonS3Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FrameworkController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request, $model)
    {
        $class = 'App\\' . ucfirst($model);
        return $class::paginate($request->per_page);
    }

    public function paginate(Request $request, $model)
    {
        $class = 'App\\' . ucfirst($model);
        $temp_model = new $class();
        $fillable_attributes = $temp_model->getFillable();
        return view('Framework::paginate', [
            'fields' => $fillable_attributes,
            'model' => $model,
            'resources' => $class::paginate(100)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create($model)
    {
        $class = 'App\\' . ucfirst($model);
        $temp_model = new $class();
        $fillable_attributes = $temp_model->getFillable();

        $table = $temp_model->getTable();

        $sql = "select column_name,data_type,is_nullable from information_schema.columns where table_name = '$table'";
        $results = app('db')->select($sql);
        $results = json_decode(json_encode($results), true);

        foreach ($results as $index => $column){
            if(!in_array($column['column_name'], $fillable_attributes)){
                unset($results[$index]);
            }else if($column['data_type'] === 'bigint'){
                $class = 'App\\' . str_replace(" ", "", ucwords(str_replace("_", " ", $column['column_name'])));
                $results[$index]['options'] = $class::all();
            }
        }

        return view('Framework::create', [
            'fields' => $results,
            'model' => ucfirst($model),
        ]);
    }

    public function submit(Request $request, $model){
        $this->store($request, $model);
        return redirect('/api/framework/view/' . $model);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request, $model)
    {
        $class = 'App\\' . ucfirst($model);
        $resource = new $class();
        $fillable_attributes = $resource->getFillable();
        foreach($fillable_attributes as $attribute){
            if(!empty($request->$attribute)){
                if(strpos($attribute, 's3_url')){
                    $url = AmazonS3Helper::UploadtoS3(file_get_contents($request->file($attribute)), 'framework/' . $model . '/' . $request->file($attribute)->hashName(),'image/' . $request->file($attribute)->extension());
                    $resource->$attribute = $url;
                }else{
                    if($request->$attribute === 'on'){
                        $resource->$attribute = 1;
                    }else{
                        $resource->$attribute = $request->$attribute;
                    }
                }
            }
        }
        $resource->save();
        return response([
            "data" => $resource
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param $class
     * @param int $id
     * @return void
     */
    public function show($model, $id)
    {
        $class = 'App\\' . ucfirst($model);
        $resource = $class::find($id);
        if(empty($resource)){
            return response([
                "error" => "Resource not found"
            ], 404);
        }
        return response([
            "data" => $resource
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($model, $id)
    {
        $class = 'App\\' . ucfirst($model);
        $temp_model = $class::find($id);
        $fillable_attributes = $temp_model->getFillable();

        $table = $temp_model->getTable();

        $sql = "select column_name,data_type,is_nullable from information_schema.columns where table_name = '$table'";
        $results = app('db')->select($sql);
        $results = json_decode(json_encode($results), true);

        foreach ($results as $index => $column){
            if(!in_array($column['column_name'], $fillable_attributes)){
                unset($results[$index]);
            }else if($column['data_type'] === 'bigint'){
                $class = 'App\\' . str_replace(" ", "", ucwords(str_replace("_", " ", $column['column_name'])));
                $results[$index]['options'] = $class::all();
                $results[$index]['value'] = $temp_model[$column['column_name']];
            }else{
                $results[$index]['value'] = $temp_model[$column['column_name']];
            }
        }

        return view('Framework::edit', [
            'id' => $id,
            'fields' => $results,
            'model' => ucfirst($model),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $model, $id)
    {
        $class = 'App\\' . ucfirst($model);
        $resource = $class::find($id);
        if(empty($resource)){
            return response([
                "error" => "Resource not found"
            ], 404);
        }
        $update = [];
        $fillable_attributes = $resource->getFillable();
        foreach($fillable_attributes as $attribute){
            if(strpos($attribute, 's3_url')){
                if(!empty($request->file($attribute))){
                    $url = AmazonS3Helper::UploadtoS3(file_get_contents($request->file($attribute)), 'framework/' . $model . '/' . $request->file($attribute)->hashName(),'image/' . $request->file($attribute)->extension());
                    $update[$attribute] = $url;
                }
            }else{
                $update[$attribute] = $request->$attribute;
            }
        }
        $resource->update($update);
        return response([
            "data" => $resource
        ], 200);
    }

    public function patch(Request $request, $model, $id){
        $this->update($request, $model, $id);
        return redirect('/api/framework/view/' . $model);
    }

    public function delete_form($model, $id){
        return view('Framework::delete', [
            'id' => $id,
            'model' => ucfirst($model),
        ]);
    }

    public function delete($model, $id){
        $this->destroy($model, $id);
        return redirect('/api/framework/view/' . $model);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($model, $id)
    {
        $class = 'App\\' . ucfirst($model);
        $resource = $class::find($id);
        if(empty($resource)){
            return response([
                "error" => "Resource not found"
            ], 404);
        }
        $resource->delete();
        return response([
            "data" => $resource
        ], 200);
    }
}
