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
        Schema::create('population', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('nik', 20)->unique();
            $table->string('place_of_birth', 150)->nullable();
            $table->enum('gender', ['l', 'p'])->default('l');
            $table->string('village', 191);
            $table->string('district', 191);
            $table->string('address', 191)->nullable();
            $table->string('neighbourhood');
            $table->string('hamlet');
            $table->string('religion', 191)->nullable();
            $table->string('married', 191)->nullable();
            $table->string('relation', 191)->nullable();
            $table->string('occupation', 191)->nullable();
            $table->enum('status', ['ada', 'meninggal', 'pindah'])->default('ada');
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
        Schema::dropIfExists('population');
    }
};
