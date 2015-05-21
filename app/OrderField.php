<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderField extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'order_fields';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['form_id', 'cid', 'order_id', 'label', 'field_type', 'field_value'];

    public function form()
    {
        return $this->belongsTo('App\Form');
    }

    public function order()
    {
        return $this->belongsTo('App\Order');
    }

}
