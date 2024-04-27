<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNavigationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('navigation', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('module_name','255')->default('');
            $table->enum('ismain_module',['Y','N'])->default('N');
            $table->enum('module_id',['0'])->default('0');
            $table->string('submodule_name','255')->default('');
            $table->enum('issub_modue',['Y','N'])->default('N');
            $table->tinyInteger('parent_module_id')->default('0');
            $table->tinyInteger('user_type')->default('0');
            $table->tinyInteger('department_id')->default('0');
            $table->datetime('created_date');
            $table->foreign('user_type')->references('id')->on('user_type');
            $table->foreign('department_id')->references('id')->on('department');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('navigation');
    }
}
