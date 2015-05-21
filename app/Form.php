<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Form extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'forms';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['user_id', 'name'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function form_field()
    {
        return $this->hasMany('App\FormField');
    }

}
