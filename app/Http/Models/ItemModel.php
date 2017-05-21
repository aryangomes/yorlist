<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ItemModel
 * @package App\Http\Models
 */
class ItemModel extends Model
{
    protected $table = 'items';

    protected $fillable = ['idItem','name','categories_idCategory','created_at','updated_at'];

    protected $visible = ['idItem','name','categories_idCategory','created_at','updated_at'];

    protected $primaryKey = 'idItem';

}
