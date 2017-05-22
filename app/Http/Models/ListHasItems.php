<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;


class ListHasItems extends Model
{
    protected $primaryKey = 'idListHasItems';

    protected $table = 'list_has_items';

    protected $fillable = ['idListHasItems','lists_idList', 'items_idItem', 'price', 'isInCart', 'qtd', 'subTotal', 'unit', 'created_at', 'updated_at'];

    protected $visible = ['idListHasItems','lists_idList', 'items_idItem', 'price', 'isInCart', 'qtd', 'subTotal', 'unit', 'created_at', 'updated_at'];


}
