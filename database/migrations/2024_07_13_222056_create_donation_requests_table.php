<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDonationRequestsTable extends Migration {

	public function up()
	{
		Schema::create('donation_requests', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('patient_name');
			$table->string('patient_phone');
			$table->string('hospital_name');
			$table->integer('blood_type_id')->unsigned();
			$table->string('patient_age');
			$table->string('bags_num');
			$table->string('hospital_address');
			$table->text('details');
			$table->decimal('latitude', 10,8);
			$table->decimal('longtude', 10,8);
			$table->integer('client_id')->unsigned();
			$table->integer('city_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('donation_requests');
	}
}