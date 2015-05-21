<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormFieldsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('form_fields', function(Blueprint $table)
		{
			$table->integer('form_id')->unsigned();
			$table->integer('order')->unsigned();
			$table->integer('cid')->unsigned();
			$table->string('label');
			$table->string('field_type');
			$table->string('required');
			$table->text('field_options');
			$table->timestamps();

			$table->primary(['form_id', 'cid', 'order']);

			$table->foreign('form_id')
		      ->references('id')->on('forms')
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
		Schema::drop('form_fields');
	}

}
