<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Category
 * @package App\Http\Models
 */
class Category extends Model
{
    protected $table = 'categories';

    protected $fillable = ['idCategory','category','created_at','updated_at'];

    protected $visible = ['idCategory','category','created_at','updated_at'];

    protected $primaryKey = 'idCategory';
}
