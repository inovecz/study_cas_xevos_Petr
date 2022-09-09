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
        Schema::create('employees', static function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('remote_id')->unique()->index();
            $table->string('name');
            $table->string('surname');
            $table->date('remote_date')->nullable();
            $table->unsignedBigInteger('active_salary_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
};
