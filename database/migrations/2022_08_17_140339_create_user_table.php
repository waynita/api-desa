<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use phpDocumentor\Reflection\Types\Null_;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('family_id')->index('idx_family_id')->nullable()->default(NULL);
            $table->string('name');
            $table->string('username', 191)->unique()->nullable()->default(NULL);
            $table->string('email', 191)->unique();
            $table->string('password', 400);
            $table->string('avatar_id', 191)->nullable()->default(null);
            $table->enum('gender', ['l', 'p'])->nullable()->default(null);
            $table->date('birthdate')->nullable()->default(null);
            $table->integer('position_id')->default(1);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->tinyInteger('show')->default(1);
            $table->rememberToken();
            $table->string('forgot_token', 500)->nullable()->default(null);
            $table->timestamp('forgot_token_expired_at')->nullable()->default(null);
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
        Schema::dropIfExists('users');
    }
};
