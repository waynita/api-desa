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
            $table->integer('head_id')->index('head_id', 'idx_head_id');
            $table->string('village', 191);
            $table->string('neighbourhood');
            $table->string('hamlet');
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
