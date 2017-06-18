<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Models\ListHasItems;
use App\Http\Models\ListModel;
use App\Http\Requests\ListHasItemRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use League\Flysystem\Exception;

class ListHasItemController extends Controller
{
    public function update(Request $request)
    {
        $data = $request->all()['data'];

        $idListHasItems = $data[0]['idListHasItems'];
        try {

            DB::beginTransaction();

            $totalPrice = 0;

            foreach ($data as $item) {
                $listHasItem = ListHasItems::where('idListHasItems', $item['idListHasItems'])
                    ->first();

                $subTotal = ListHasItems::calculateSubTotal($item['price'], $item['qtd']);

                $listHasItem->update([
                    'items_idItem' => $item['items_idItem'],
                    'qtd' => $item['qtd'],
                    'price' => $item['price'],
                    'isInCart' => $item['isInCart'],
                    'unit' => $item['unit'],
                    'subTotal' => $subTotal,
                ]);

                $totalPrice += $subTotal;

            }

            $list = ListModel::where('idList','=', $data[0]['lists_idList'])->first();

            $list->update(
                ['totalPrice'=>$totalPrice]
            );

            DB::commit();

        } catch (Exception $exception) {

            DB::rollBack();

            return response()->json([
                'message' => 'Error.: '.$exception->getMessage(),
            ], 504);
        }


        $listHasItem = ListHasItems::where('lists_idList','=', $data[0]['lists_idList'])->get();

        if (!isset($listHasItem)) {

            return response()->json([
                'message' => 'Record not found',
            ], 404);

        }

        $items = [];

        foreach ($listHasItem as $item) {

            array_push($items, $item->item);
            $list = $item->getList;
        }




        return response()->json($listHasItem, 201);

    }
}
