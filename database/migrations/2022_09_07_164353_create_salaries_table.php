<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salaries', static function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->references('remote_id')->on('employees');
            $table->foreignId('employeer_id')->references('id')->on('employeers');
            $table->float('salary');
            $table->timestamps();
        });

        Schema::table('employees', static function (Blueprint $table) {
            $table->foreign('active_salary_id')->references('id')->on('salaries')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('salaries');
    }
};
