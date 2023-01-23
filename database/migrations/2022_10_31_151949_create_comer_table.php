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
        Schema::create('comer', function (Blueprint $table) {
            $table->id();
            $table->string('nik', 20)->nullable();
            $table->string('name', 20);
            $table->enum('gender', ['l', 'p'])->default('l');
            $table->timestamp('date_of_come');
            $table->integer('whistleblower_id');
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
        Schema::dropIfExists('comer');
    }
};
