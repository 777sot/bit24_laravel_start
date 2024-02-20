<?php

namespace App\Http\Controllers\Api\Leads;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Leads\Dependency\StoreRequest;
use App\Http\Requests\Api\Leads\Dependency\UpdateRequest;
use App\Http\Resources\Api\Fields\DependencyResource;
use App\Http\Resources\Api\Fields\FieldResource;
use App\Models\Field;
use App\Models\ListDependency;
use App\Models\ListField;
use Illuminate\Http\Request;

class DependencyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fields = ListDependency::all();
        return DependencyResource::collection($fields);
    }

    /**
     * Display a listing of the resource.
     */
    public function list(string $id)
    {
        $lists = ListDependency::where('list_field_id', $id)->get();
        if (count($lists)) {
            return DependencyResource::collection($lists);
        }
        return array('data' => [
            'status' => false,
            'messages' => 'Dependency is not found',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validated();

        $field = ListDependency::firstOrCreate([
            'list_field_id' => $data['list_field_id'],
            'field_id' => $data['field_id'],
        ], $data);

        if ($field) {
            return new DependencyResource($field);
        } else {
            return array('data' => ['status' => false]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $field = ListDependency::find($id);

        if ($field) {
            return new DependencyResource($field);
        } else {
            return array('data' => [
                'status' => false,
                'messages' => 'Dependency is not found',
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id)
    {
        $data = $request->validated();

        $field = ListDependency::find($id);

        if ($field) {

            $field->update($data);
            $field->refresh();

            return new DependencyResource($field);

        } else {
            return array('data' => [
                'status' => false,
                'messages' => 'Dependency is not found',
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {


        $field = ListDependency::find($id);

        if ($field) {

            $field->delete();
            return array('data' => [
                'status' => true,
                'messages' => 'Dependency is deleted',
            ]);
        } else {
            return array('data' => [
                'status' => false,
                'messages' => 'Dependency is not found',
            ]);
        }
    }
}
