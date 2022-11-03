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
        Schema::create('family', function (Blueprint $table) {
            $table->id();
            $table->string('number_family', 20);
            $table->string('head', 191)->nullable();
            $table->string('village', 191);
            $table->integer('neighbourhood');
            $table->integer('hamlet');
            $table->string('sub_districts', 191);
            $table->string('districts', 191);
            $table->string('province', 191);
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
        Schema::dropIfExists('family');
    }
};
