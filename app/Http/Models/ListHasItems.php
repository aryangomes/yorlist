<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ListHasItems
 * @package App\Http\Models
 */
class ListHasItems extends Model
{
    protected $table = 'list_has_items';

    protected $fillable = ['lists_idList','items_idItem','price','isInCart','qtd','subTotal','unit','created_at','updated_at'];

    protected $visible = ['lists_idList','items_idItem','price','isInCart','qtd','subTotal','unit','created_at','updated_at'];

    protected $primaryKey = ['lists_idList','items_idItem'];

    protected $incremeting = false;


}
