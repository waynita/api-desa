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
        Schema::create('menu', function (Blueprint $table) {
            $table->id();
            $table->string('name', 191);
            $table->string('icon', 191);
            $table->string('url', 191)->nullable();
            $table->string('slug', 191);
            $table->integer('parent_id')->index('parent_id', 'idx_parent_id')->nullable();
            $table->integer('sorting');
            $table->string('file', 191)->nullable();
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
        Schema::dropIfExists('menu');
    }
};
