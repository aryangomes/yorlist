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

    public static $ID_LIST_CURRENT = 0;

    protected $table = 'lists';

    protected $fillable = ['idList', 'user_id', 'totalPrice', 'created_at', 'updated_at'];

    protected $visible = ['idList', 'user_id', 'totalPrice', 'created_at', 'updated_at'];

    protected $primaryKey = 'idList';

    //Sum the value of the total price of list
    public static $OPERATOR_SUM = 1;

    //Subtract the value of the total price of list
    public static $OPERATOR_SUBTRACT = 0;


    /**
     * @param float $value
     * @param int $operator
     */
    public function calculateTotalPrice($value, $operator = 1)
    {
        $this->totalPrice = ($operator) ? ($this->totalPrice + $value) :
            ($this->totalPrice - $value);

        $this->save();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany('\App\Http\Models\ListHasItems', 'lists_idList', 'idList');
    }

}
