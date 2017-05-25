<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Models\ItemModel;
use App\Http\Requests\ItemRequest;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $items = ItemModel::orderBy('categories_idCategory')->get()->all();

        return response()->json($items);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ItemRequest $request)
    {
        $item = new ItemModel();

        $item->fill($request->all());

        $item->save();

        return response()->json($item, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = ItemModel::where('idItem', $id)->first();

        if (!isset($item)) {
            return response()->json([
                'message' => 'Record not found',
            ], 404);
        }

        return response()->json($item);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(ItemRequest $request, $id)
    {
        $item = ItemModel::where('idItem', $id)->first();

        if (!isset($item)) {
            return response()->json([
                'message' => 'Record not found',
            ], 404);
        }


        $item->update($request->all());

        return response()->json($item, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $item = ItemModel::findOrFail($id);

        if (!isset($item)) {
            return response()->json([
                'message' => 'Record not found',
            ], 404);
        }


        $item->delete();

        return response()->json([
            'message' => 'Record removed!',
        ], 201);
    }


    /**
     * Search a item by name
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        $searchItem = ItemModel::where('name','like' , '%'. $request['name'] . '%')->get();

        if (count($searchItem) <= 0) {
            return response()->json([
                'message' => 'Records not found',
            ], 404);
        }

        return response()->json($searchItem);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchByCategory(Request $request)
    {

        $items = ItemModel::where('categories_idCategory',$request['idCategory'])->get()->all();

        if (count($items) <= 0) {
            return response()->json([
                'message' => 'Records not found',
            ], 404);
        }

        return response()->json($items);
    }
}
