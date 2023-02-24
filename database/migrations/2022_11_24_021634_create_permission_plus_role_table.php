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
        Schema::create('permission_plus_role', function (Blueprint $table) {
            $table->bigInteger('permission_plus_id')->unsigned();
            $table->bigInteger('role_id')->unsigned();

            $table->primary(['permission_plus_id', 'role_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permission_plus_role');
    }
};
