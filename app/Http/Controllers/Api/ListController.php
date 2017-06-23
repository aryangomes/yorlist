<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Models\ItemModel;
use App\Http\Models\ListHasItems;
use App\Http\Models\ListModel;
use App\Http\Requests\ListHasItemRequest;
use App\Http\Requests\ListRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $lists = ListModel::where('user_id', Auth::id())
            ->orderBy('created_at', 'DESC')
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
    public function store()
    {
        $list = new ListModel();

        DB::beginTransaction();

        try {

            $list = $list->create(['user_id' =>
                Auth::id()]);

            ListModel::$ID_LIST_CURRENT = $list->idList;

            DB::commit();

            return response()->json($list, 201);
        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json($e->getMessage(), 501);

        }
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


    /**
     * Add a item in a list
     * @param ListHasItemRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addItem(ListHasItemRequest $request)
    {

        $list = ListModel::where('idList', $request->all()['lists_idList'])->first();

        $item = ItemModel::where('idItem', $request->all()['items_idItem'])->first();

        if (!isset($list) && !isset($item)) {
            return response()->json([
                'message' => 'Record not found',
            ], 404);
        }

        $listHasItem = new ListHasItems();

        $subTotal = ListHasItems::calculateSubTotal($request->all()['price'], $request->all()['qtd']);

        $request->merge(['subTotal' => $subTotal]);

        $listHasItem->fill($request->all());

        $listHasItem->save();

        $list->calculateTotalPrice($subTotal, ListModel::$OPERATOR_SUM);

        return response()->json([
            'message' => 'Item added in list!',
        ], 201);
    }

    /**
     * Remove a item from a list
     * @param ListHasItemRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeItem(Request $request)
    {

        $listHasItem = ListHasItems::where('idListHasItems', $request->all()['idListHasItems'])
            ->first();

        if (!isset($listHasItem)) {
            return response()->json([
                'message' => 'Record not found',
            ], 404);
        }

        $subTotal = ListHasItems::calculateSubTotal($listHasItem->price, $listHasItem->qtd);

        $listHasItem->getList->calculateTotalPrice($subTotal, ListModel::$OPERATOR_SUBTRACT);

        $listHasItem->delete();

        return response()->json([
            'message' => 'Item removed from list!',
        ], 201);
    }



    /**
     * Clone a list
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function cloneList(Request $request)
    {

        $list = ListModel::where('idList', $request->all()['idList'])->first();

        if (!isset($list)) {
            return response()->json([
                'message' => 'Record not found',
            ], 404);
        }

        DB::beginTransaction();

        try {

            $newList = new ListModel();

            $newList->fill([
                'totalPrice' => $list->totalPrice,
                'user_id' => $list->user_id
            ]);

            $newList->save();

            foreach ($list->items as $item) {

                $newListHasItem = new ListHasItems();

                $newDataListHasItem = $item->toArray();

                $newDataListHasItem = array_slice($newDataListHasItem, 1);

                $newDataListHasItem["lists_idList"] = $newList->idList;

                $newListHasItem->fill($newDataListHasItem);

                $newListHasItem->save();
            }

            DB::commit();

            return response()->json($newList, 201);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json($e->getMessage(), 501);

        }

    }

    public function items($id)
    {
        $listHasItems = ListHasItems::where('lists_idList', $id)->get();

        if (!isset($listHasItems)) {
            return response()->json([
                'message' => 'Record not found',
            ], 404);
        }

        $items = [];
        foreach ($listHasItems as $item) {

            array_push($items, $item->item);

            $list = $item->getList;
        }


        return response()->json($listHasItems);
    }

}
