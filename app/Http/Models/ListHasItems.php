<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;


class ListHasItems extends Model
{
    protected $primaryKey = 'idListHasItems';

    protected $table = 'list_has_items';

    protected $fillable = ['idListHasItems', 'lists_idList', 'items_idItem', 'price', 'isInCart', 'qtd', 'subTotal', 'unit', 'created_at', 'updated_at','item'];

    protected $visible = ['idListHasItems', 'lists_idList', 'items_idItem', 'price', 'isInCart', 'qtd', 'subTotal', 'unit', 'created_at', 'updated_at', 'item'];


    /**
     * Calculates the subtotal of a item
     * @param float $price
     * @param int $qtd
     * @return float
     */
    public static function calculateSubTotal($price, $qtd = 1)
    {
        $subTotal = floatval($price) * floatval($qtd);
        return $subTotal;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function getList()
    {
        return $this->belongsTo('\App\Http\Models\ListModel', 'lists_idList', 'idList');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function item()
    {
        return $this->belongsTo('\App\Http\Models\ItemModel', 'items_idItem', 'idItem');
    }


}
