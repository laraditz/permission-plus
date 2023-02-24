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
        Schema::create('permission_plus', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->json('methods')->nullable();
            $table->string('uri');
            $table->string('route_name')->nullable();
            $table->string('action_name')->nullable();
            $table->smallInteger('allow_all')->default(0);
            $table->smallInteger('allow_guest')->default(0);
            $table->unsignedInteger('sort_order')->nullable();
            $table->smallInteger('is_active')->default(1);
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
        Schema::dropIfExists('permission_plus');
    }
};
