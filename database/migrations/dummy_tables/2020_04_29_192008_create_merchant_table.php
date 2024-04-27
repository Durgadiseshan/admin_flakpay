<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMerchantTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchant', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',50);
            $table->string('email',50);
            $table->string('mobile_no',10);
            $table->string('password',10);
            $table->string('verify_token',50);
            $table->tinyInteger('app_mode');
            $table->timestamps();
            
        });

        'name', 'email','mobile_no','password',
        'verify_token','app_mode','merchant_gid','created_date','last_seen_at'
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('merchant');
    }
}
