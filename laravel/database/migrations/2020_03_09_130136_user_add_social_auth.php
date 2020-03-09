<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UserAddSocialAuth extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('social_id')->default('');
            $table->enum('social_type', ['site', 'github']);
            $table->string('avatar', 225)->default('');
            $table->index('social_id');
            $table->string('password', 255)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['social_id', 'social_type', 'avatar']);
            $table->string('password', 255)->change();
        });
    }
}
