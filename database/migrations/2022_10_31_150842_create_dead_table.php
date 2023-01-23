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
        Schema::create('dead', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->index('user_id', 'idx_user_id');
            $table->text('cause_of_death')->nullable();
            $table->timestamp('date_of_death');
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
        Schema::dropIfExists('dead');
    }
};
