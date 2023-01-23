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
        Schema::create('permission_position', function (Blueprint $table) {
            $table->id();
            $table->enum('read', ['full', 'restrict', 'deny']);
            $table->tinyInteger('create');
            $table->tinyInteger('update');
            $table->tinyInteger('delete');
            $table->integer('position_id')->index('position_id', 'idx_position_id');
            $table->integer('menu_id')->index('menu_id', 'idx_menu');
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
        Schema::dropIfExists('permission_position');
    }
};
