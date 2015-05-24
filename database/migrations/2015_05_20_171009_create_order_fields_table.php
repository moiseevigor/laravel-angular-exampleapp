<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderFieldsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('order_fields', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('order_id')->unsigned()->index();
			$table->string('label');
			$table->string('field_type');
			$table->boolean('required');
			$table->text('field_options');
			$table->text('value');
			$table->timestamps();

			$table->foreign('order_id')
				->references('id')->on('orders')
				->onUpdate('cascade')
				->onDelete('cascade');

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('order_fields');
	}

}
