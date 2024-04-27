<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('employee_username',50);
            $table->string('first_name',50);
            $table->string('last_name',50);
            $table->string('designation',50);
            $table->string('personal_email',50);
            $table->string('official_email',50);
            $table->string('mobile_no',10);
            $table->string('password',255);
            $table->tinyInteger('department');
            $table->tinyInteger('user_type');
            $table->dateTime('created_date');
            $table->smallInteger('created_by');

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee');
    }
}
