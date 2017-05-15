<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class ItemModel extends Model
{
    protected $table = 'items';

    protected $fillable = ['idItem','name','created_at','updated_at'];

    protected $visible = ['idItem','name','created_at','updated_at'];

}
