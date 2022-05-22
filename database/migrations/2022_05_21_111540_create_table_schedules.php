<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('has_monday')->nullable();
            $table->tinyInteger('has_tuesday')->nullable();
            $table->tinyInteger('has_wednesday')->nullable();
            $table->tinyInteger('has_thursday')->nullable();
            $table->tinyInteger('has_friday')->nullable();
            $table->tinyInteger('has_saturday')->nullable();
            $table->tinyInteger('has_sunday')->nullable();
            $table->text('frequency')->nullable();
            $table->date('date', 255)->nullable();
            $table->text('time')->nullable();
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
        Schema::dropIfExists('table_schedules');
    }
};
