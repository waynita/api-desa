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
        Schema::table('oauth_refresh_tokens', function (Blueprint $table) {
            $table->string('id', 191)->change();
            $table->string('access_token_id', 191)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('oauth_refresh_tokens', function (Blueprint $table) {
            $table->string('id', 100)->change();
            $table->string('access_token_id', 100)->change();
        });
    }
};
