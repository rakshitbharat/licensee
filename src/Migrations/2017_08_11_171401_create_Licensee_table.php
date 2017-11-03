<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Config;

class CreateLicenseeTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        $user_table = Config('licensee.user_table');
        Schema::create($user_table . '_role', function(Blueprint $table) {
            $user_table = Config('licensee.user_table');
            $table->increments('id');
            $table->string($user_table . '_role_description', 191)->nullable();
            $table->string($user_table . '_role_slug', 191);
            $table->timestamps();
        });

        Schema::create($user_table . '_permission', function(Blueprint $table) {
            $user_table = Config('licensee.user_table');
            $table->increments('id');
            $table->string($user_table . '_permission_description', 191)->nullable();
            $table->string($user_table . '_permission_slug', 191);
            $table->boolean('status')->default(0)->comment('0 = No, 1 = Yes');
            $table->timestamps();
        });

        Schema::table($user_table, function(Blueprint $table) {
            $user_table = Config('licensee.user_table');
            $table->integer($user_table . '_role_id')->unsigned()->nullable();
            $table->foreign($user_table . '_role_id')->references('id')->on($user_table . '_role');
        });

        Schema::table($user_table . '_permission', function(Blueprint $table) {
            $user_table = Config('licensee.user_table');
            $table->integer($user_table . '_role_id')->unsigned()->nullable();
            $table->foreign($user_table . '_role_id')->references('id')->on($user_table . '_role');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        $user_table = Config('licensee.user_table');
        Schema::dropIfExists($user_table . '_role');
        Schema::dropIfExists($user_table . '_permission');

        Schema::table($user_table, function(Blueprint $table) {
            $user_table = Config('licensee.user_table');
            $table->dropColumn($user_table . '_role_id');
        });
        Schema::table($user_table . '_permission', function(Blueprint $table) {
            $user_table = Config('licensee.user_table');
            $table->dropColumn($user_table . '_role_id');
        });
    }

}
