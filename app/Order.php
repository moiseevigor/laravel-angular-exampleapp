<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'orders';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['user_id', 'form_id'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function form()
    {
        return $this->belongsTo('App\Form');
    }

    public function order_field()
    {
        return $this->hasMany('App\OrderField');
    }

}
