<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Models\ListModel;
use App\Http\Requests\ListRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $lists = ListModel::where('user_id', app('Dingo\Api\Auth\Auth')->user()->id)
            ->orderBy('created_at','DESC')
            ->get()->all();


        return response()->json($lists);
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
    public function store(ListRequest $request)
    {
        $list = new ListModel();

        $request->request->add(['user_id'=>
            app('Dingo\Api\Auth\Auth')->user()->id]);

        $list->fill($request->all());

        $list->save();

        return response()->json($list, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $list = ListModel::where('idList', $id)->first();

        if (!isset($list)) {
            return response()->json([
                'message' => 'Record not found',
            ], 404);
        }

        return response()->json($list);
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
    public function update(ListRequest $request, $id)
    {
        $list = ListModel::where('idList', $id)->first();

        if (!isset($list)) {
            return response()->json([
                'message' => 'Record not found',
            ], 404);
        }


        $list->update($request->all());

        return response()->json($list, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $list = ListModel::findOrFail($id);

        if (!isset($list)) {
            return response()->json([
                'message' => 'Record not found',
            ], 404);
        }


        $list->delete();

        return response()->json([
            'message' => 'Record removed!',
            ], 201);
    }
}
