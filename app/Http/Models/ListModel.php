<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;


/**
 * Class ListModel
 * @package App\Models
 * @property $user_id int
 */
class ListModel extends Model
{

    protected $table = 'lists';

    protected $fillable = ['idList','user_id','totalPrice','created_at','updated_at'];

    protected $visible = ['idList','user_id','totalPrice','created_at','updated_at'];

}
