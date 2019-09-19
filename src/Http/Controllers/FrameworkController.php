<?php

namespace daxter1987\Framework\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FrameworkController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($model)
    {
        $class = 'App\\' . ucfirst(strtolower($model));
        return $class::paginate();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request, $model)
    {
        $class = 'App\\' . ucfirst(strtolower($model));
        $resource = $class::create($request->all());
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
        $class = 'App\\' . ucfirst(strtolower($model));
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $model, $id)
    {
        $class = 'App\\' . ucfirst(strtolower($model));
        $resource = $class::find($id);
        if(empty($resource)){
            return response([
                "error" => "Resource not found"
            ], 404);
        }
        $resource->update($request->all());
        return response([
            "data" => $resource
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($model, $id)
    {
        $class = 'App\\' . ucfirst(strtolower($model));
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
